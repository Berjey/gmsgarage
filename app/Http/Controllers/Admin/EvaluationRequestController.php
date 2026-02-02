<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationRequest;
use App\Models\SentEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EvaluationRequestController extends Controller
{
    /**
     * Display a listing of evaluation requests
     */
    public function index()
    {
        $requests = EvaluationRequest::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.evaluation-requests.index', compact('requests'));
    }

    /**
     * Display a specific evaluation request
     */
    public function show($id)
    {
        $request = EvaluationRequest::findOrFail($id);
        if (!$request->is_read) {
            $request->markAsRead();
        }
        return view('admin.evaluation-requests.show', compact('request'));
    }

    /**
     * Mark request as read
     */
    public function markAsRead($id)
    {
        $request = EvaluationRequest::findOrFail($id);
        $request->markAsRead();
        return back()->with('success', 'İstek okundu olarak işaretlendi.');
    }

    /**
     * Delete an evaluation request
     */
    public function destroy($id)
    {
        $request = EvaluationRequest::findOrFail($id);
        $request->delete();
        return redirect()->route('admin.evaluation-requests.index')
            ->with('success', 'İstek başarıyla silindi.');
    }


    /**
     * Download evaluation request as PDF
     */
    public function downloadPdf($id)
    {
        try {
            // DomPDF paketinin yüklü olup olmadığını kontrol et
            if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                return back()->with('error', 'PDF paketi yüklü değil. Lütfen "composer install" komutunu çalıştırın.');
            }

            $request = EvaluationRequest::findOrFail($id);

            // PDF oluştur
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.evaluation-requests.pdf', compact('request'));
            $pdf->setPaper('A4', 'portrait');
            
            // Türkçe karakter desteği için encoding ayarları
            $pdf->setOption('enable-local-file-access', true);
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', false);
            $pdf->setOption('defaultFont', 'DejaVu Sans');
            $pdf->setOption('enable_font_subsetting', false);
            $pdf->setOption('dpi', 96);
            
            // Dosya adını müşteri adı soyadı ile oluştur
            $customerName = \Illuminate\Support\Str::slug($request->name, '-');
            $filename = 'degerleme-raporu-' . $customerName . '-' . date('Ymd') . '.pdf';
            
            // Dosya adını temizle (geçersiz karakterleri kaldır)
            $filename = preg_replace('/[^a-z0-9\-_\.]/i', '', $filename);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('PDF download error: ' . $e->getMessage());
            return back()->with('error', 'PDF oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Send email to user with IMAP APPEND support
     */
    public function sendEmail(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'recipient_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $evaluationRequest = EvaluationRequest::findOrFail($id);

        // Rate limit kontrolü
        $recentCount = SentEmail::where('created_at', '>=', now()->subMinute())
            ->where('status', 'sent')
            ->count();

        if ($recentCount >= 10) {
            return response()->json([
                'success' => false,
                'message' => 'Çok fazla mail gönderimi yapıldı. Lütfen bir dakika bekleyin.'
            ], 429);
        }

        // HTML ve plain text body oluştur
        $htmlBody = $this->generateHtmlTemplate(
            $evaluationRequest->name,
            $request->message,
            'degerleme_alindi',
            'DEG-' . $id
        );

        $plainTextBody = $this->generatePlainTextBody(
            $evaluationRequest->name,
            $request->message
        );

        // Veritabanına kayıt oluştur
        $sentEmail = SentEmail::create([
            'to' => $request->recipient_email,
            'subject' => $request->subject,
            'customer_name' => $evaluationRequest->name,
            'request_type' => 'degerleme_alindi',
            'reference_id' => 'DEG-' . $id,
            'message_text' => $request->message,
            'html_body' => $htmlBody,
            'plain_text_body' => $plainTextBody,
            'status' => 'pending',
        ]);

        try {
            // SMTP ile mail gönder
            $messageId = $this->sendViaSMTP(
                $request->recipient_email,
                $request->subject,
                $htmlBody,
                $plainTextBody
            );

            // IMAP ile Sent klasörüne ekle
            $this->appendToSentFolder(
                $request->recipient_email,
                $request->subject,
                $htmlBody,
                $plainTextBody,
                $messageId
            );

            // Başarılı
            $sentEmail->update([
                'status' => 'sent',
                'smtp_message_id' => $messageId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'E-posta başarıyla gönderildi ve Sent klasörüne kaydedildi.'
            ]);

        } catch (\Exception $e) {
            Log::error('Mail gönderim hatası: ' . $e->getMessage());

            $sentEmail->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'E-posta gönderilirken hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * HTML template oluştur
     */
    private function generateHtmlTemplate($customerName, $messageText, $requestType = null, $referenceId = null)
    {
        $logoUrl = asset('images/light-mode-logo.png');
        $primaryColor = '#dc2626';
        $brandName = 'GMSGARAGE';
        $brandTagline = 'Premium Oto Galeri';

        $safeMessage = nl2br(e($messageText));

        $html = '<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . e($brandName) . '</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 600px;">
                    <tr>
                        <td style="background: linear-gradient(135deg, ' . $primaryColor . ' 0%, #b91c1c 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . e($brandName) . '</h1>
                            <p style="color: #fecaca; margin: 5px 0 0 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">' . e($brandTagline) . '</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #1f2937; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0; font-family: Arial, Helvetica, sans-serif;">
                                Sayın <strong>' . e($customerName) . '</strong>,
                            </p>
                            <div style="color: #4b5563; font-size: 15px; line-height: 1.6; margin: 0 0 20px 0; font-family: Arial, Helvetica, sans-serif;">
                                ' . $safeMessage . '
                            </div>';

        if ($referenceId) {
            $html .= '<div style="background-color: #f9fafb; border-left: 4px solid ' . $primaryColor . '; padding: 15px; margin: 20px 0; border-radius: 4px;">
                            <p style="color: #1f2937; font-size: 13px; margin: 0; font-family: Arial, Helvetica, sans-serif;">
                                <strong>Referans No:</strong> ' . e($referenceId) . '
                            </p>
                        </div>';
        }

        $html .= '</td>
                    </tr>
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #6b7280; font-size: 12px; margin: 0 0 10px 0; font-family: Arial, Helvetica, sans-serif;">
                                <strong>' . e($brandName) . '</strong><br>
                                ' . e($brandTagline) . '
                            </p>
                            <p style="color: #9ca3af; font-size: 11px; margin: 0; font-family: Arial, Helvetica, sans-serif;">
                                Bu e-posta otomatik olarak gönderilmiştir.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

        return $html;
    }

    /**
     * Plain text body oluştur
     */
    private function generatePlainTextBody($customerName, $messageText)
    {
        return "Sayın " . $customerName . ",\n\n" . $messageText . "\n\nSaygılarımızla,\nGMSGARAGE\nPremium Oto Galeri";
    }

    /**
     * SMTP ile mail gönder
     */
    private function sendViaSMTP($to, $subject, $htmlBody, $plainTextBody)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = config('mail.mailers.smtp.host');
        $mail->SMTPAuth = true;
        $mail->Username = config('mail.mailers.smtp.username');
        $mail->Password = config('mail.mailers.smtp.password');
        $mail->SMTPSecure = config('mail.mailers.smtp.encryption') === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = config('mail.mailers.smtp.port');
        $mail->CharSet = 'UTF-8';

        $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $htmlBody;
        $mail->AltBody = $plainTextBody;

        $mail->send();

        return $mail->getLastMessageID();
    }

    /**
     * IMAP ile Sent klasörüne ekle
     */
    private function appendToSentFolder($to, $subject, $htmlBody, $plainTextBody, $messageId)
    {
        try {
            $imapHost = '{' . config('mail.mailers.smtp.host') . ':993/imap/ssl}Sent';
            $imapUsername = config('mail.mailers.smtp.username');
            $imapPassword = config('mail.mailers.smtp.password');

            $imap = @imap_open($imapHost, $imapUsername, $imapPassword);

            if (!$imap) {
                Log::warning('IMAP bağlantısı kurulamadı: ' . imap_last_error());
                return;
            }

            $from = config('mail.from.address');
            $fromName = config('mail.from.name');
            $date = date('r');

            $email = "From: {$fromName} <{$from}>\r\n";
            $email .= "To: {$to}\r\n";
            $email .= "Subject: {$subject}\r\n";
            $email .= "Date: {$date}\r\n";
            $email .= "Message-ID: {$messageId}\r\n";
            $email .= "MIME-Version: 1.0\r\n";
            $email .= "Content-Type: multipart/alternative; boundary=\"boundary-string\"\r\n\r\n";
            $email .= "--boundary-string\r\n";
            $email .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
            $email .= $plainTextBody . "\r\n\r\n";
            $email .= "--boundary-string\r\n";
            $email .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
            $email .= $htmlBody . "\r\n\r\n";
            $email .= "--boundary-string--\r\n";

            imap_append($imap, $imapHost, $email, "\\Seen");
            imap_close($imap);

            Log::info('Mail Sent klasörüne eklendi: ' . $to);
        } catch (\Exception $e) {
            Log::warning('IMAP APPEND hatası: ' . $e->getMessage());
        }
    }
}
