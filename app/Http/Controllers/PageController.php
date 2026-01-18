<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'message.required' => 'Mesaj alanı zorunludur.',
            'message.min' => 'Mesaj en az 10 karakter olmalıdır.',
        ]);

        // Save to database
        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject ?? 'İletişim Formu',
            'message' => $request->message,
        ]);

        return back()->with('success', 'Mesajınız başarıyla gönderildi! En kısa sürede size dönüş yapacağız.');
    }

    public function vehicleRequest()
    {
        // Model yılları listesi (mevcut yıl + 1'den 1990'a kadar)
        $currentYear = (int) date('Y');
        $years = range($currentYear + 1, 1990);
        
        // Araç tipleri
        $vehicleTypes = [
            'AUTO' => 'Otomobil',
            'SUV' => 'SUV',
            'TICARI' => 'Ticari',
            'MOTOSIKLET' => 'Motosiklet',
        ];

        // Yakıt tipleri
        $fuelTypes = [
            'BENZIN' => 'Benzin',
            'DIZEL' => 'Dizel',
            'HIBRIT' => 'Hibrit',
            'ELEKTRIK' => 'Elektrik',
        ];

        // İletişim yöntemleri
        $contactMethods = [
            'TELEFON' => 'Telefon',
            'WHATSAPP' => 'WhatsApp',
            'EMAIL' => 'E-posta',
        ];

        return view('pages.vehicle-request', compact('years', 'vehicleTypes', 'fuelTypes', 'contactMethods'));
    }

    public function vehicleRequestSubmit(Request $request)
    {
        // Custom validation for contact (phone or email)
        $request->validate([
            'vehicle_type' => 'required|in:AUTO,SUV,TICARI,MOTOSIKLET',
            'brand' => 'required|string|min:2|max:255',
            'model' => 'nullable|string|min:2|max:255',
            'year' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'kilometre' => 'nullable|integer|min:0|max:9999999',
            'fuel_type' => 'nullable|in:BENZIN,DIZEL,HIBRIT,ELEKTRIK',
            'city' => 'nullable|string|min:2|max:255',
            'contact' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                // Check if it's an email
                if (strpos($value, '@') !== false) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('Geçerli bir telefon numarası veya e-posta adresi girin.');
                    }
                } else {
                    // Phone validation (remove spaces, +90, leading 0)
                    $phone = preg_replace('/[\s\+\-\(\)]/', '', $value);
                    $phone = preg_replace('/^90/', '', $phone);
                    $phone = preg_replace('/^0/', '', $phone);
                    
                    if (!preg_match('/^[0-9]{10}$/', $phone)) {
                        $fail('Geçerli bir telefon numarası veya e-posta adresi girin.');
                    }
                }
            }],
            'contact_method' => 'nullable|in:TELEFON,WHATSAPP,EMAIL',
            'note' => 'nullable|string|max:1000',
        ], [
            'vehicle_type.required' => 'Araç tipi seçimi zorunludur.',
            'brand.required' => 'Marka alanı zorunludur.',
            'brand.min' => 'Marka en az 2 karakter olmalıdır.',
            'model.min' => 'Model en az 2 karakter olmalıdır.',
            'contact.required' => 'İletişim bilgisi zorunludur.',
        ]);

        // Parse contact info
        $contact = $request->contact;
        $email = null;
        $phone = null;
        
        if (strpos($contact, '@') !== false) {
            $email = $contact;
        } else {
            $phone = $contact;
        }
        
        // Save to database
        VehicleRequest::create([
            'name' => $request->name ?? 'İsimsiz',
            'email' => $email ?? 'noreply@gmsgarage.com',
            'phone' => $phone ?? $contact,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'budget' => $request->budget ?? null,
            'message' => $request->note,
        ]);

        return back()->with('success', 'Talebiniz başarıyla gönderildi! En kısa sürede size dönüş yapacağız.');
    }

    public function kvkk()
    {
        return view('pages.kvkk');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function landing()
    {
        return view('pages.landing');
    }
}
