<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by source
        if ($source = $request->get('source')) {
            $query->where('source', $source);
        }

        // Order by latest
        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Müşteri bilgileri başarıyla güncellendi.');
    }

    /**
     * Remove the specified customer from storage
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Müşteri başarıyla silindi.');
    }

    /**
     * Export customers to CSV
     */
    public function export(Request $request)
    {
        $query = Customer::query();

        // Apply same filters as index
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($source = $request->get('source')) {
            $query->where('source', $source);
        }

        $customers = $query->orderBy('created_at', 'desc')->get();

        // Create CSV content
        $csvData = "Ad Soyad,E-posta,Telefon,Kaynak,KVKK Onayı,IP Adresi,Kayıt Tarihi\n";
        
        foreach ($customers as $customer) {
            $csvData .= sprintf(
                '"%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $customer->name,
                $customer->email ?? 'N/A',
                $customer->phone ?? 'N/A',
                $customer->source ?? 'N/A',
                $customer->kvkk_consent ? 'Evet' : 'Hayır',
                $customer->ip_address ?? 'N/A',
                $customer->created_at->format('d.m.Y H:i')
            );
        }

        // Return CSV file
        $fileName = 'musteriler_' . now()->format('Y-m-d_His') . '.csv';
        
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ]);
    }

    /**
     * Send bulk email to customers
     */
    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'customer_ids' => 'required|array|min:1',
            'customer_ids.*' => 'exists:customers,id',
        ], [
            'subject.required' => 'E-posta konusu zorunludur.',
            'message.required' => 'E-posta mesajı zorunludur.',
            'customer_ids.required' => 'En az bir müşteri seçmelisiniz.',
            'customer_ids.min' => 'En az bir müşteri seçmelisiniz.',
        ]);

        $customers = Customer::whereIn('id', $request->customer_ids)
                             ->whereNotNull('email')
                             ->get();

        $successCount = 0;
        $failCount = 0;

        foreach ($customers as $customer) {
            try {
                Mail::send([], [], function ($message) use ($customer, $request) {
                    $message->to($customer->email, $customer->name)
                        ->subject($request->subject)
                        ->html(nl2br(e($request->message)));
                });
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                \Log::error('Bulk email failed for customer: ' . $customer->email . ' - ' . $e->getMessage());
            }
        }

        if ($successCount > 0) {
            return redirect()->route('admin.customers.index')
                ->with('success', "{$successCount} müşteriye e-posta başarıyla gönderildi." . ($failCount > 0 ? " ({$failCount} başarısız)" : ""));
        } else {
            return redirect()->route('admin.customers.index')
                ->with('error', 'E-posta gönderimi başarısız oldu. Lütfen mail ayarlarınızı kontrol edin.');
        }
    }
}
