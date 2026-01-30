# 📧 MAİL SİSTEMİ KURULUM KILAVUZU

## ✅ YAPILAN DEĞİŞİKLİKLER

### A) UI / Light Mode Düzeltmeleri ✨
**Dosya:** `resources/views/admin/contact-messages/index.blade.php`

**Değişiklikler:**
- ✅ Dropdown panel'lere açık border ve soft shadow eklendi
- ✅ Dropdown option'lar light mode renkleri aldı (gray-50 hover, red accent)
- ✅ Trigger button'lara `focus:ring-2 focus:ring-primary-500/20` eklendi
- ✅ Text color `text-gray-800`, hover `hover:bg-gray-50` yapıldı
- ✅ Koyu shadow/border kalıntıları temizlendi

### B) "Yeni" Badge Yeşil Renk 🟢
**Dosya:** `resources/views/admin/components/message-badge.blade.php`

**Değişiklikler:**
- ✅ "Yeni" badge: `bg-green-100 text-green-800 border-green-300`
- ✅ Pulse nokta: `bg-green-600`
- ✅ "Okundu" badge: `bg-gray-100 text-gray-700` (nötr gri)

### C) Mail Gönderim Sistemi 📬

## 🔧 HOSTINGER MAIL KURULUMU

### 1. .env Dosyasını Düzenle

`.env` dosyasında aşağıdaki değerleri Hostinger bilgilerinizle değiştirin:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=info@gmsgarage.com
MAIL_PASSWORD=YOUR_HOSTINGER_MAIL_PASSWORD_HERE  # ← BU ŞİFREYİ DEĞİŞTİR!
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@gmsgarage.com"
MAIL_FROM_NAME="GMSGARAGE"
```

### 2. Hostinger Mail Şifresini Alma

1. Hostinger paneline giriş yap
2. **E-postalar** bölümüne git
3. `info@gmsgarage.com` hesabını seç
4. **Şifre değiştir** veya mevcut şifreyi kullan
5. Şifreyi yukarıdaki `MAIL_PASSWORD` alanına yapıştır

### 3. Config Cache Temizleme

```bash
cd C:\Users\gmskr\gmsgarage
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 4. Test Email Gönderimi

```bash
php artisan tinker
```

Tinker açıldığında:

```php
Mail::raw('Test mesajı - GMSGARAGE Mail Sistemi', function($m) {
    $m->to('YOUR_TEST_EMAIL@gmail.com')
      ->subject('GMSGARAGE Mail Test');
});
```

Çıkış için: `exit`

## 🔍 SORUN GİDERME

### Hata: "Connection refused"
- ❌ MAIL_HOST yanlış → `smtp.hostinger.com` olmalı
- ❌ MAIL_PORT yanlış → `587` (TLS) veya `465` (SSL)
- ❌ Firewall bloklama → Port 587/465 açık olmalı

### Hata: "Authentication failed"
- ❌ Yanlış şifre → Hostinger'dan şifreyi kontrol et
- ❌ 2FA aktif → App-specific password kullan
- ❌ MAIL_USERNAME yanlış → `info@gmsgarage.com` tam email olmalı

### Hata: "Sender address rejected"
- ❌ MAIL_FROM_ADDRESS doğrulanmamış → Domain'e ait email kullan
- ❌ SPF/DMARC hatası → `no-reply@gmsgarage.com` gibi domain'e ait adres kullan

### Mail Gönderiliyor Ama Inbox'a Gelmiyor
1. **Spam klasörünü kontrol et**
2. **SPF/DKIM kayıtlarını kontrol et** (Hostinger DNS ayarları)
3. **Mail log'larını incele:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## 📊 LOG KONTROL

İletişim formu gönderildiğinde log'lara bakın:

```bash
# Windows PowerShell
Get-Content storage\logs\laravel.log -Tail 50

# veya
notepad storage\logs\laravel.log
```

**Başarılı gönderim log'u:**
```
Contact form email sent successfully
recipient: info@gmsgarage.com
contact_message_id: 1
```

**Hatalı gönderim log'u:**
```
Contact form email could not be sent
error: Connection refused [smtp.hostinger.com:587]
```

## ✅ TEST ADIMI ADIM

1. **Hostinger şifresini `.env`'e ekle**
2. **Config cache temizle**: `php artisan config:clear`
3. **Test mail gönder** (tinker komutu)
4. **Inbox kontrol et** (spam dahil)
5. **Websiteden form gönder**: http://localhost:8000/iletisim
6. **Admin panelde mesajı gör**: http://localhost:8000/admin/contact-messages
7. **Hostinger inbox'a mail geldiğini onayla**

## 🚀 ÜRETİM ORTAMI (PRODUCTION)

Production'da aşağıdaki komutu çalıştır:

```bash
php artisan config:cache
```

Bu komut .env'i cache'e alır ve performans artırır. Değişiklik yaparsan tekrar çalıştır.

## 📋 HATIRLATMALAR

- ✅ `.env` dosyasını asla GitHub'a pushlama
- ✅ Mail şifresi güvenli olmalı
- ✅ `MAIL_FROM_ADDRESS` domain'e ait olmalı
- ✅ Spam olmamak için SPF/DKIM/DMARC DNS kayıtları ayarla
- ✅ Test mail'i kendi emailine gönder
- ✅ Production'da `config:cache` çalıştır

## 🎯 SONUÇ

Tüm adımlar tamamlandığında:
- 🟢 Dropdown'lar Light Mode uyumlu
- 🟢 "Yeni" badge yeşil renkte
- 🟢 İletişim formu mail gönderiyor
- 🟢 Hostinger inbox'a mail düşüyor

---

**Not:** Herhangi bir sorun olursa `storage/logs/laravel.log` dosyasını kontrol edin!
