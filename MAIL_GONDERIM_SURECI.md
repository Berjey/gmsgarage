# 📧 Mail Gönderim Süreci - Hostinger SMTP

## 🔄 Mail Nasıl Gönderiliyor?

### 1. **Laravel Mail Sistemi**
- Laravel'in `Mail::send()` fonksiyonu kullanılıyor
- SwiftMailer/Swift SMTP protokolü üzerinden çalışıyor

### 2. **SMTP Bağlantısı**
```
Laravel Uygulaması → Hostinger SMTP Sunucusu (smtp.hostinger.com:465)
```

### 3. **Kimlik Doğrulama**
- **SMTP Sunucusu:** `smtp.hostinger.com`
- **Port:** `465` (SSL şifreleme ile)
- **Kullanıcı Adı:** `info@gmsgarage.com`
- **Şifre:** `Srf.0727`
- **Şifreleme:** `SSL`

### 4. **Mail Gönderim Akışı**

```
1. Admin Panel → "E-posta Gönder" butonuna tıklama
   ↓
2. EvaluationRequestController::sendEmail() metodu çalışıyor
   ↓
3. Mail::send() fonksiyonu çağrılıyor
   ↓
4. Laravel, Hostinger SMTP sunucusuna bağlanıyor
   ├─ Host: smtp.hostinger.com
   ├─ Port: 465
   ├─ Encryption: SSL
   ├─ Username: info@gmsgarage.com
   └─ Password: Srf.0727
   ↓
5. SMTP kimlik doğrulama yapılıyor
   ↓
6. Mail içeriği hazırlanıyor (evaluation-response.blade.php template)
   ↓
7. Mail gönderiliyor
   ├─ From: info@gmsgarage.com (GMSGARAGE)
   ├─ To: Müşteri e-posta adresi
   ├─ Subject: Admin tarafından yazılan konu
   └─ Message: Admin tarafından yazılan mesaj
   ↓
8. Hostinger SMTP sunucusu maili gönderiyor
   ↓
9. Mail müşterinin inbox'ına ulaşıyor
```

## 📍 Mail Nereden Geliyor?

### **Gönderen Bilgileri:**
- **E-posta Adresi:** `info@gmsgarage.com`
- **Gönderen İsmi:** `GMSGARAGE`
- **SMTP Sunucusu:** `smtp.hostinger.com` (Hostinger)
- **Reply-To:** `info@gmsgarage.com`

### **Hostinger Kontrol Paneli:**
Mail Hostinger kontrol panelinden değil, **Laravel uygulaması üzerinden** gönderiliyor. 

Hostinger kontrol panelinde görmek için:
1. Hostinger kontrol paneline giriş yapın
2. **E-postalar** bölümüne gidin
3. `info@gmsgarage.com` hesabına girin
4. **Giden Kutusu** veya **Gönderilenler** klasörünü kontrol edin

**Not:** Bazı hosting sağlayıcıları, SMTP üzerinden gönderilen mailleri "Gönderilenler" klasörüne kaydetmeyebilir. Bu normaldir.

## 🔍 Mail Gönderim Logları

Mail gönderim logları şu dosyada tutuluyor:
```
storage/logs/laravel.log
```

### Başarılı Gönderim:
```
[2026-XX-XX XX:XX:XX] local.INFO: Mail sent successfully
```

### Hata Durumu:
```
[2026-XX-XX XX:XX:XX] local.ERROR: Mail transport error: ...
```

## 📊 Mail Gönderim Detayları

### Controller: `EvaluationRequestController::sendEmail()`

**Dosya:** `app/Http/Controllers/Admin/EvaluationRequestController.php`

**Kod Akışı:**
1. Form validasyonu (konu ve mesaj kontrolü)
2. SMTP ayarları kontrolü
3. Mail template hazırlama (`emails.evaluation-response`)
4. SMTP bağlantısı ve gönderim
5. Başarı/hata mesajı döndürme

### Mail Template: `evaluation-response.blade.php`

**Dosya:** `resources/views/emails/evaluation-response.blade.php`

**İçerik:**
- Kurumsal tasarım
- Müşteri adı
- Admin mesajı
- Araç bilgileri (marka, model, yıl, kilometre)
- Footer bilgileri

## ✅ Mail Gönderim Kontrolü

### 1. **SMTP Ayarları Kontrolü:**
```bash
php artisan tinker
```
Sonra:
```php
config('mail.mailers.smtp.host')      // smtp.hostinger.com
config('mail.mailers.smtp.port')      // 465
config('mail.mailers.smtp.username') // info@gmsgarage.com
config('mail.from.address')           // info@gmsgarage.com
```

### 2. **Test Mail Gönderimi:**
```bash
php artisan tinker
```
Sonra:
```php
Mail::raw('Test mesajı', function ($message) {
    $message->to('test@example.com')
             ->subject('Test E-postası');
});
```

## 🎯 Özet

**Mail gönderim yolu:**
```
Laravel Uygulaması (localhost:8000)
    ↓
Hostinger SMTP Sunucusu (smtp.hostinger.com:465)
    ↓
Müşteri E-posta Adresi
```

**Gönderen:** `info@gmsgarage.com` (Hostinger'da oluşturulan e-posta hesabı)

**SMTP Kullanımı:** Evet, Hostinger SMTP sunucusu kullanılıyor

**Hostinger Kontrol Paneli:** Mail gönderim işlemi Laravel üzerinden yapıldığı için Hostinger kontrol panelinde "Gönderilenler" klasöründe görünmeyebilir. Bu normaldir.

---

**Not:** Mail gönderim loglarını kontrol etmek için:
```bash
Get-Content storage\logs\laravel.log -Tail 50
```
