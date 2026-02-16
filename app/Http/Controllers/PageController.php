<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\VehicleRequest;
use App\Models\Setting;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    /**
     * Dinamik sayfa görüntüleme (yasal sayfalar için)
     */
    public function show($slug)
    {
        // Cache ile performans (5 dakika)
        $page = Cache::remember("page.{$slug}", 300, function () use ($slug) {
            return Page::where('slug', $slug)
                ->where('is_active', true)
                ->first();
        });

        if (!$page) {
            abort(404, 'Sayfa bulunamadı');
        }

        return view('pages.show', compact('page'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        // İletişim sayfası ayarlarını al
        $contactSettings = [
            'email' => Setting::get('contact_email', 'info@gmsgarage.com'),
            'phone' => Setting::get('contact_phone', '0555 123 45 67'),
            'whatsapp' => Setting::get('contact_whatsapp', '0555 123 45 67'),
            'address' => Setting::get('contact_address', 'Görsel Mah. Kağıthane Cad. No: 26 /1A KAĞITHANE/İSTANBUL'),
            'google_maps_embed' => Setting::get('contact_google_maps_embed', ''),
            'form_description' => Setting::get('contact_form_description', 'Sorularınız, önerileriniz veya destek talepleriniz için aşağıdaki formu doldurun. Mesajınız info@gmsgarage.com adresine gönderilecektir.'),
        ];
        
        return view('pages.contact', compact('contactSettings'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{0,11}$/', 'max:11'],
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:1000',
        ], [
            'name.required' => 'Ad Soyad alanı zorunludur.',
            'name.min' => 'Ad Soyad en az 2 karakter olmalıdır.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'phone.regex' => 'Telefon numarası sadece rakamlardan oluşmalı ve en fazla 11 haneli olmalıdır.',
            'phone.max' => 'Telefon numarası en fazla 11 haneli olmalıdır.',
            'message.required' => 'Mesaj alanı zorunludur.',
            'message.min' => 'Mesaj en az 10 karakter olmalıdır.',
            'message.max' => 'Mesaj en fazla 1000 karakter olabilir.',
        ]);

        // Save to database
        $contactMessage = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject ?? 'İletişim Formu',
            'message' => $request->message,
        ]);

        // Send email to configured recipient
        $mailRecipient = Setting::get('contact_mail_recipient', 'info@gmsgarage.com');
        
        // Mail göndermeyi dene, hata olsa bile devam et
        try {
            Mail::send('emails.contact', [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject ?? 'İletişim Formu',
                'messageContent' => $request->message, // $message Laravel'in Mail Message objesi ile çakışıyor
                'created_at' => $contactMessage->created_at->format('d.m.Y H:i'),
            ], function ($message) use ($request, $mailRecipient) {
                $message->to($mailRecipient)
                       ->replyTo($request->email, $request->name) // Geri yanıt için kullanıcının e-postasını ayarla
                       ->subject('Yeni İletişim Formu Mesajı: ' . ($request->subject ?? 'İletişim Formu'));
            });
            
            \Log::info('Contact form email sent successfully', [
                'contact_message_id' => $contactMessage->id,
                'recipient' => $mailRecipient,
            ]);
        } catch (\Throwable $e) {
            // Mail gönderme hatası - log'a kaydet ama kullanıcıya hata gösterme
            \Log::error('Contact form email could not be sent', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'contact_message_id' => $contactMessage->id,
                'recipient' => $mailRecipient,
                'mail_config' => [
                    'default' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'encryption' => config('mail.mailers.smtp.encryption'),
                    'username' => config('mail.mailers.smtp.username'),
                ],
            ]);
            // Mesaj veritabanına kaydedildi, mail gönderilemese bile devam et
        }

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
