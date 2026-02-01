<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
     * Send email to user
     */
    public function sendEmail(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $evaluationRequest = EvaluationRequest::findOrFail($id);

        try {
            // Hostinger SMTP ile uyumlu mail gönderimi
            // ÖNEMLİ: MAIL_USERNAME ve MAIL_FROM_ADDRESS aynı olmalı
            $smtpUsername = config('mail.mailers.smtp.username');
            $fromAddress = config('mail.from.address');
            $fromName = config('mail.from.name', 'GMS GARAGE');
            
            // Eğer MAIL_USERNAME ayarlanmışsa, from adresi olarak onu kullan
            // Hostinger SMTP kimlik doğrulaması için bu kritik
            if ($smtpUsername && $smtpUsername !== $fromAddress) {
                \Log::warning('MAIL_USERNAME ve MAIL_FROM_ADDRESS eşleşmiyor. MAIL_USERNAME kullanılıyor: ' . $smtpUsername);
                $fromAddress = $smtpUsername;
            }
            
            // SMTP ayarlarını kontrol et
            if (empty($smtpUsername) || empty(config('mail.mailers.smtp.password'))) {
                return back()->with('error', 'SMTP kimlik bilgileri eksik. Lütfen .env dosyasında MAIL_USERNAME ve MAIL_PASSWORD ayarlarını kontrol edin.');
            }
            
            // Mail gönderimi artık panel üzerinden değil, Hostinger webmail üzerinden yapılıyor
            // Bu metod artık kullanılmıyor, sadece geriye dönük uyumluluk için bırakıldı


            return back()->with('success', 'E-posta başarıyla gönderildi.');
        } catch (\Swift_TransportException $e) {
            \Log::error('Mail transport error: ' . $e->getMessage());
            \Log::error('SMTP Config: ' . json_encode([
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'username' => config('mail.mailers.smtp.username') ?: 'AYARLANMAMIŞ',
                'has_password' => !empty(config('mail.mailers.smtp.password')),
                'from_address' => config('mail.from.address'),
            ]));
            
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, '530') !== false || strpos($errorMessage, 'Authentication') !== false) {
                return back()->with('error', 'SMTP kimlik doğrulama hatası. Lütfen .env dosyasında MAIL_USERNAME ve MAIL_PASSWORD ayarlarını kontrol edin. MAIL_USERNAME ve MAIL_FROM_ADDRESS aynı e-posta adresi olmalıdır.');
            }
            
            
            return back()->with('error', 'E-posta gönderilemedi. Lütfen SMTP ayarlarınızı kontrol edin. Hata: ' . $errorMessage);
        } catch (\Exception $e) {
            \Log::error('Evaluation email send error: ' . $e->getMessage());
            \Log::error('Mail config: ' . json_encode([
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'encryption' => config('mail.mailers.smtp.encryption'),
                'username' => config('mail.mailers.smtp.username') ? '***' : null,
                'from' => config('mail.from'),
            ]));
            
            
            return back()->with('error', 'E-posta gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }
}
