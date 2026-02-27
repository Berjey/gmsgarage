<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationRequest;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluationRequestController extends Controller
{
    /**
     * Display a listing of evaluation requests
     */
    public function index()
    {
        $requests = EvaluationRequest::orderBy('created_at', 'desc')
                                     ->paginate(15)
                                     ->withQueryString();

        $stats = [
            'total' => EvaluationRequest::count(),
            'new'   => EvaluationRequest::where('is_read', false)->count(),
            'read'  => EvaluationRequest::where('is_read', true)->count(),
        ];

        return view('admin.evaluation-requests.index', compact('requests', 'stats'));
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
     * Değerleme isteği sahibine e-posta gönder
     */
    public function sendEmail(Request $request, $id)
    {
        $evalRequest = EvaluationRequest::findOrFail($id);

        if (empty($evalRequest->email)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu müşterinin e-posta adresi kayıtlı değil.',
            ], 422);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'subject.required' => 'E-posta konusu zorunludur.',
            'message.required' => 'Mesaj zorunludur.',
        ]);

        $result = EmailService::sendTo(
            email:   $evalRequest->email,
            name:    $evalRequest->name,
            subject: $request->subject,
            body:    $request->message,
            context: ['source' => 'evaluation_request', 'evaluation_id' => $evalRequest->id]
        );

        return response()->json($result, $result['success'] ? 200 : 500);
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
        $request = EvaluationRequest::findOrFail($id);

        $pdf = Pdf::loadView('admin.evaluation-requests.pdf', compact('request'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'degerleme-raporu-' . $request->id . '-' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
