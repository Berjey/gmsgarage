<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SentEmail;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MailSendController extends Controller
{
    /**
     * Mail gönderme sayfası
     */
    public function index()
    {
        return view('admin.mail-send.index');
    }

    /**
     * Mail gönderim kayıtları
     */
    public function logs()
    {
        $emails = SentEmail::orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return view('admin.mail-send.logs', compact('emails'));
    }

    /**
     * Mail önizleme
     */
    public function preview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'request_type' => 'nullable|in:degerleme_alindi,iletisim_alindi',
            'reference_id' => 'nullable|string|max:255',
            'message_text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $htmlBody = $this->generateHtmlTemplate(
            $request->customer_name,
            $request->message_text,
            $request->request_type,
            $request->reference_id
        );

        return response()->json([
            'success' => true,
            'html' => $htmlBody
        ]);
    }

    /**
     * Mail gönder
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'request_type' => 'nullable|in:degerleme_alindi,iletisim_alindi',
            'reference_id' => 'nullable|string|max:255',
            'message_text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Rate limit kontrolü (basit)
        $recentCount = SentEmail::where('created_at', '>=', now()->subMinute())
            ->where('status', 'sent')
            ->count();

        if ($recentCount >= 10) {
            return back()->with('error', 'Çok fazla mail gönderimi yapıldı. Lütfen bir dakika bekleyin.')->withInput();
        }

        // HTML ve plain text body oluştur
        $htmlBody = $this->generateHtmlTemplate(
            $request->customer_name,
            $request->message_text,
            $request->request_type,
            $request->reference_id
        );

        $plainTextBody = $this->generatePlainTextBody(
            $request->customer_name,
            $request->message_text
        );

        // Veritabanına kayıt oluştur
        $sentEmail = SentEmail::create([
            'to' => $request->recipient_email,
            'subject' => $request->subject,
            'customer_name' => $request->customer_name,
            'request_type' => $request->request_type,
            'reference_id' => $request->reference_id,
            'message_text' => $request->message_text,
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

            return back()->with('success', 'E-posta başarıyla gönderildi ve Sent klasörüne kaydedildi.');

        } catch (\Exception $e) {
            Log::error('Mail gönderim hatası: ' . $e->getMessage());

            $sentEmail->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'E-posta gönderilirken hata oluştu: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * HTML template oluştur
     */
    private function generateHtmlTemplate($customerName, $messageText, $requestType = null, $referenceId = null)
    {
        $logoUrl = config('mail.brand.logo_url', asset('images/light-mode-logo.png'));
        $primaryColor = config('mail.brand.primary_color', '#dc2626');
        $brandName = config('mail.brand.name', 'GMSGARAGE');
        $brandTagline = config('mail.brand.tagline', 'Premium Oto Galeri');
        $brandWebsite = config('mail.brand.website', 'https://gmsgarage.com');
        $brandPhone = config('mail.brand.phone', '');
        $brandAddress = config('mail.brand.address', '');

        // Mesajı güvenli şekilde HTML'e çevir (sadece satır sonlarını <br> yap)
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
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, ' . $primaryColor . ' 0%, ' . $this->darkenColor($primaryColor, 20) . ' 100%); padding: 30px; text-align: center;">
                            <img src="' . $logoUrl . '" alt="' . e($brandName) . '" style="max-width: 200px; height: auto; margin-bottom: 10px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold; font-family: Arial, Helvetica, sans-serif;">' . e($brandName) . '</h1>
                            <p style="color: #fecaca; margin: 5px 0 0 0; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">' . e($brandTagline) . '</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
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
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #6b7280; font-size: 12px; margin: 0 0 10px 0; font-family: Arial, Helvetica, sans-serif;">
                                <strong>' . e($brandName) . '</strong><br>';

        if ($brandPhone) {
            $html .= e($brandPhone) . '<br>';
        }

        if ($brandAddress) {
            $html .= e($brandAddress) . '<br>';
        }

        $html .= '<a href="' . $brandWebsite . '" style="color: ' . $primaryColor . '; text-decoration: none;">' . $brandWebsite . '</a>
                            </p>
                            <p style="color: #9ca3af; font-size: 11px; margin: 10px 0 0 0; font-family: Arial, Helvetica, sans-serif;">
                                Bu e-posta otomatik olarak gönderilmiştir. Lütfen bu e-postaya yanıt vermeyin.
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
        $brandName = config('mail.brand.name', 'GMSGARAGE');
        $brandWebsite = config('mail.brand.website', 'https://gmsgarage.com');

        $text = "Sayın {$customerName},\n\n";
        $text .= strip_tags($messageText) . "\n\n";
        $text .= "Saygılarımızla,\n";
        $text .= "{$brandName}\n";
        $text .= $brandWebsite;

        return $text;
    }

    /**
     * SMTP ile mail gönder
     */
    private function sendViaSMTP($to, $subject, $htmlBody, $plainTextBody)
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP ayarları
            $mail->isSMTP();
            $mail->Host = config('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mailers.smtp.username');
            $mail->Password = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = config('mail.mailers.smtp.encryption');
            $mail->Port = config('mail.mailers.smtp.port');
            $mail->CharSet = 'UTF-8';

            // Gönderen bilgileri
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($to);

            // İçerik
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $plainTextBody;

            $mail->send();

            return $mail->getLastMessageID();

        } catch (Exception $e) {
            throw new \Exception("SMTP Hatası: {$mail->ErrorInfo}");
        }
    }

    /**
     * IMAP ile Sent klasörüne ekle
     */
    private function appendToSentFolder($to, $subject, $htmlBody, $plainTextBody, $messageId)
    {
        $imapHost = config('mail.imap.host');
        $imapPort = config('mail.imap.port', 993);
        $imapUser = config('mail.imap.username');
        $imapPass = config('mail.imap.password');
        $sentFolder = config('mail.imap.sent_folder', 'Sent');

        if (!$imapHost || !$imapUser || !$imapPass) {
            Log::warning('IMAP ayarları eksik, Sent klasörüne eklenemedi');
            return;
        }

        try {
            // IMAP bağlantısı
            $mailbox = "{{$imapHost}:{$imapPort}/imap/ssl}";
            $connection = imap_open($mailbox, $imapUser, $imapPass);

            if (!$connection) {
                throw new \Exception('IMAP bağlantısı kurulamadı: ' . imap_last_error());
            }

            // RFC822 formatında mesaj oluştur
            $fromEmail = config('mail.from.address');
            $fromName = config('mail.from.name');
            $date = date('r');

            $rfc822Message = $this->createRfc822Message(
                $fromEmail,
                $fromName,
                $to,
                $subject,
                $htmlBody,
                $plainTextBody,
                $messageId,
                $date
            );

            // Sent klasörüne ekle
            $result = imap_append($connection, $mailbox . $sentFolder, $rfc822Message);

            if (!$result) {
                throw new \Exception('Sent klasörüne eklenemedi: ' . imap_last_error());
            }

            imap_close($connection);

        } catch (\Exception $e) {
            Log::error('IMAP APPEND hatası: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * RFC822 formatında mesaj oluştur
     */
    private function createRfc822Message($fromEmail, $fromName, $to, $subject, $htmlBody, $plainTextBody, $messageId, $date)
    {
        $boundary = '----=_Part_' . md5(uniqid(time()));

        $message = "Message-ID: {$messageId}\r\n";
        $message .= "Date: {$date}\r\n";
        $message .= "From: {$fromName} <{$fromEmail}>\r\n";
        $message .= "To: {$to}\r\n";
        $message .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $message .= "MIME-Version: 1.0\r\n";
        $message .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
        $message .= "\r\n";

        // Plain text part
        $message .= "--{$boundary}\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: quoted-printable\r\n";
        $message .= "\r\n";
        $message .= $this->quotedPrintableEncode($plainTextBody) . "\r\n";
        $message .= "\r\n";

        // HTML part
        $message .= "--{$boundary}\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: quoted-printable\r\n";
        $message .= "\r\n";
        $message .= $this->quotedPrintableEncode($htmlBody) . "\r\n";
        $message .= "\r\n";

        // End boundary
        $message .= "--{$boundary}--\r\n";

        return $message;
    }

    /**
     * Quoted-Printable encoding (PHP 8.1+ için uyumlu)
     */
    private function quotedPrintableEncode($text)
    {
        if (function_exists('quoted_printable_encode')) {
            return quoted_printable_encode($text);
        }
        
        // Fallback: Manuel encoding
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $text = preg_replace('/[^\x20-\x7E\n]/', '', $text);
        $text = preg_replace('/[ \t]+$/', '', $text);
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = str_replace("\n", "\r\n", $text);
        
        return $text;
    }

    /**
     * Renk koyulaştır
     */
    private function darkenColor($color, $percent)
    {
        $color = str_replace('#', '', $color);
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));

        $r = max(0, $r - ($r * $percent / 100));
        $g = max(0, $g - ($g * $percent / 100));
        $b = max(0, $b - ($b * $percent / 100));

        return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) .
                   str_pad(dechex($g), 2, '0', STR_PAD_LEFT) .
                   str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }
}
