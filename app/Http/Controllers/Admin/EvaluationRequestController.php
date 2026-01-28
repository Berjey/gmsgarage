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

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.evaluation-requests.pdf', compact('request'));
            $pdf->setPaper('A4', 'portrait');

            $filename = 'degerleme-raporu-' . $request->id . '-' . date('Ymd') . '.pdf';

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
            Mail::send('emails.evaluation-response', [
                'evaluationRequest' => $evaluationRequest,
                'subject' => $request->subject,
                'messageContent' => $request->message,
            ], function ($message) use ($evaluationRequest, $request) {
                $message->from(config('mail.from.address'), config('mail.from.name', 'GMS GARAGE'))
                       ->to($evaluationRequest->email, $evaluationRequest->name)
                       ->subject($request->subject);
            });

            return back()->with('success', 'E-posta başarıyla gönderildi.');
        } catch (\Exception $e) {
            \Log::error('Evaluation email send error: ' . $e->getMessage());
            \Log::error('Mail config: ' . json_encode([
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'username' => config('mail.mailers.smtp.username') ? '***' : null,
                'from' => config('mail.from'),
            ]));
            return back()->with('error', 'E-posta gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }
}
