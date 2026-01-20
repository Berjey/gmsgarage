<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class ContactSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // İletişim Sayfası Ayarları
        Setting::set('contact_email', 'info@gmsgarage.com', 'contact', 'İletişim E-posta Adresi');
        Setting::set('contact_phone', '0555 123 45 67', 'contact', 'İletişim Telefon Numarası');
        Setting::set('contact_whatsapp', '0555 123 45 67', 'contact', 'WhatsApp Numarası');
        Setting::set('contact_address', 'Görsel Mah. Kağıthane Cad. No: 26 /1A KAĞITHANE/İSTANBUL', 'contact', 'Adres');
        Setting::set('contact_google_maps_embed', '', 'contact', 'Google Maps Embed Kodu');
        Setting::set('contact_form_description', 'Sorularınız, önerileriniz veya destek talepleriniz için aşağıdaki formu doldurun. Mesajınız info@gmsgarage.com adresine gönderilecektir.', 'contact', 'Form Açıklama Metni');
        Setting::set('contact_mail_recipient', 'info@gmsgarage.com', 'contact', 'Mail Alıcı Adresi');
        Setting::set('contact_mail_hostinger_link', 'https://mail.hostinger.com/v2/mailboxes/INBOX', 'contact', 'Hostinger Mail Paneli Linki');
    }
}
