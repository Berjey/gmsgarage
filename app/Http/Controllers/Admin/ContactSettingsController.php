<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactSettingsController extends Controller
{
    /**
     * Display contact page settings
     */
    public function index()
    {
        // İletişim sayfası ayarları
        $settings = [
            'contact_email' => Setting::get('contact_email', 'info@gmsgarage.com'),
            'contact_phone' => Setting::get('contact_phone', '0555 123 45 67'),
            'contact_whatsapp' => Setting::get('contact_whatsapp', '0555 123 45 67'),
            'contact_address' => Setting::get('contact_address', 'Görsel Mah. Kağıthane Cad. No: 26 /1A KAĞITHANE/İSTANBUL'),
            'contact_google_maps_embed' => Setting::get('contact_google_maps_embed', ''),
            'contact_form_description' => Setting::get('contact_form_description', 'Sorularınız, önerileriniz veya destek talepleriniz için aşağıdaki formu doldurun. Mesajınız info@gmsgarage.com adresine gönderilecektir.'),
            'contact_mail_recipient' => Setting::get('contact_mail_recipient', 'info@gmsgarage.com'),
            'contact_mail_hostinger_link' => Setting::get('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX'),
        ];

        return view('admin.contact-settings.index', compact('settings'));
    }

    /**
     * Update contact page settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_whatsapp' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:500',
            'contact_google_maps_embed' => 'nullable|string',
            'contact_form_description' => 'nullable|string|max:1000',
            'contact_mail_recipient' => 'required|email|max:255',
            'contact_mail_hostinger_link' => 'required|url|max:500',
        ], [
            'contact_email.required' => 'E-posta adresi zorunludur.',
            'contact_email.email' => 'Geçerli bir e-posta adresi girin.',
            'contact_mail_recipient.required' => 'Mail alıcı adresi zorunludur.',
            'contact_mail_recipient.email' => 'Geçerli bir e-posta adresi girin.',
            'contact_mail_hostinger_link.required' => 'Hostinger Mail linki zorunludur.',
            'contact_mail_hostinger_link.url' => 'Geçerli bir URL girin.',
        ]);

        // Save settings
        Setting::set('contact_email', $request->contact_email, 'contact', 'İletişim E-posta Adresi');
        Setting::set('contact_phone', $request->contact_phone, 'contact', 'İletişim Telefon Numarası');
        Setting::set('contact_whatsapp', $request->contact_whatsapp, 'contact', 'WhatsApp Numarası');
        Setting::set('contact_address', $request->contact_address, 'contact', 'Adres');
        Setting::set('contact_google_maps_embed', $request->contact_google_maps_embed, 'contact', 'Google Maps Embed Kodu');
        Setting::set('contact_form_description', $request->contact_form_description, 'contact', 'Form Açıklama Metni');
        Setting::set('contact_mail_recipient', $request->contact_mail_recipient, 'contact', 'Mail Alıcı Adresi');
        Setting::set('contact_mail_hostinger_link', $request->contact_mail_hostinger_link, 'contact', 'Hostinger Mail Paneli Linki');

        return redirect()->route('admin.contact-settings.index')
            ->with('success', 'İletişim sayfası ayarları başarıyla güncellendi.');
    }
}
