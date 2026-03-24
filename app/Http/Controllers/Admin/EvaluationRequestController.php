<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationRequest;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluationRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = EvaluationRequest::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'unread') {
                $query->where('is_read', false);
            } elseif ($status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $requests = $query->orderBy('created_at', 'desc')
                          ->paginate(15)
                          ->withQueryString();

        $stats = [
            'total' => EvaluationRequest::count(),
            'new'   => EvaluationRequest::where('is_read', false)->count(),
            'read'  => EvaluationRequest::where('is_read', true)->count(),
        ];

        return view('admin.evaluation-requests.index', compact('requests', 'stats'));
    }

    public function show($id)
    {
        $request = EvaluationRequest::findOrFail($id);
        if (!$request->is_read) {
            $request->markAsRead();
        }
        return view('admin.evaluation-requests.show', compact('request'));
    }

    public function markAsRead($id)
    {
        $request = EvaluationRequest::findOrFail($id);
        $request->markAsRead();
        return back()->with('success', 'İstek okundu olarak işaretlendi.');
    }

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

    public function destroy($id)
    {
        $request = EvaluationRequest::findOrFail($id);
        $request->delete();
        return redirect()->route('admin.evaluation-requests.index')
            ->with('success', 'İstek başarıyla silindi.');
    }

    public function destroyAll()
    {
        $count = EvaluationRequest::count();
        EvaluationRequest::truncate();
        return redirect()->route('admin.evaluation-requests.index')
            ->with('success', "Tüm {$count} talep başarıyla silindi.");
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_unread,delete',
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'exists:evaluation_requests,id',
        ]);

        $ids    = $request->input('ids');
        $action = $request->input('action');
        $count  = count($ids);

        if ($action === 'mark_read') {
            EvaluationRequest::whereIn('id', $ids)->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
            return redirect()->route('admin.evaluation-requests.index')
                ->with('success', "{$count} talep okundu olarak işaretlendi.");
        }

        if ($action === 'mark_unread') {
            EvaluationRequest::whereIn('id', $ids)->update([
                'is_read' => false,
                'read_at' => null,
            ]);
            return redirect()->route('admin.evaluation-requests.index')
                ->with('success', "{$count} talep okunmamış olarak işaretlendi.");
        }

        if ($action === 'delete') {
            EvaluationRequest::whereIn('id', $ids)->delete();
            return redirect()->route('admin.evaluation-requests.index')
                ->with('success', "{$count} talep başarıyla silindi.");
        }

        return back();
    }

    public function export(Request $request)
    {
        $query = EvaluationRequest::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'unread') {
                $query->where('is_read', false);
            } elseif ($status === 'read') {
                $query->where('is_read', true);
            }
        }

        $items = $query->orderBy('created_at', 'desc')->get();

        $bom = "\xEF\xBB\xBF";
        $sep = ';';
        $esc = fn(?string $v): string => '"' . str_replace('"', '""', $v ?? '') . '"';

        $csvData = $bom . implode($sep, [
            'ID', 'Ad Soyad', 'E-posta', 'Telefon', 'Marka', 'Model', 'Yıl',
            'Yakıt', 'Vites', 'KM', 'Durum', 'Hasar', 'Tarih', 'Okundu'
        ]) . "\n";

        foreach ($items as $item) {
            $csvData .= implode($sep, [
                $esc((string) $item->id),
                $esc($item->name),
                $esc($item->email),
                $esc($item->phone),
                $esc($item->brand),
                $esc($item->model),
                $esc((string) $item->year),
                $esc($item->fuel_type),
                $esc($item->transmission),
                $esc($item->mileage ? number_format($item->mileage, 0, ',', '.') : ''),
                $esc($item->version ?? ''),
                $esc($item->condition ?? ''),
                $esc($item->created_at->format('d.m.Y H:i')),
                $esc($item->is_read ? 'Evet' : 'Hayır'),
            ]) . "\n";
        }

        $fileName = 'degerleme-istekleri_' . now()->format('Y-m-d_His') . '.csv';

        return Response::make($csvData, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    public function downloadPdf($id)
    {
        $request = EvaluationRequest::findOrFail($id);

        $pdf = Pdf::loadView('admin.evaluation-requests.pdf', compact('request'));
        $pdf->setPaper('A4', 'portrait');

        $filename = 'degerleme-raporu-' . $request->id . '-' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
