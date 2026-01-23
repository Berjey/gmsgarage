<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $request = EvaluationRequest::findOrFail($id);

        $pdf = Pdf::loadView('admin.evaluation-requests.pdf', compact('request'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'degerleme-raporu-' . $request->id . '-' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
