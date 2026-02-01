# Kurumsal E-posta Gönderim Paneli

Hostinger Email kullanan işletmeler için geliştirilmiş kurumsal e-posta gönderim paneli.

## Özellikler

- ✅ Admin panelden tek tıkla mail gönderimi
- ✅ HTML template ile otomatik formatlama (logo, footer, kurumsal renk)
- ✅ SMTP ile mail gönderimi
- ✅ IMAP APPEND ile Sent klasörüne otomatik kopya
- ✅ Gönderim kayıtları (son 100 kayıt)
- ✅ Güvenlik önlemleri (XSS koruması, rate limit)
- ✅ Önizleme özelliği

## Kurulum

### 1. Composer Dependencies

```bash
composer install
```

Bu komut aşağıdaki paketleri yükleyecektir:
- `phpmailer/phpmailer` (SMTP gönderimi için)
- `webklex/php-imap` (IMAP APPEND için)

### 2. PHP IMAP Extension

PHP IMAP extension'ının yüklü olması gerekmektedir:

**Ubuntu/Debian:**
```bash
sudo apt-get install php-imap
sudo phpenmod imap
```

**Windows (XAMPP):**
`php.ini` dosyasında şu satırı aktif edin:
```ini
extension=imap
```

**Hostinger Shared Hosting:**
Genellikle zaten yüklüdür. Kontrol etmek için:
```php
<?php phpinfo(); ?>
```

### 3. Veritabanı Migration

```bash
php artisan migrate
```

### 4. Environment Variables

`.env` dosyanıza aşağıdaki ayarları ekleyin:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@gmsgarage.com
MAIL_PASSWORD=your_password_here
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@gmsgarage.com
MAIL_FROM_NAME="GMSGARAGE"

# IMAP Configuration
IMAP_HOST=imap.hostinger.com
IMAP_PORT=993
IMAP_USER=info@gmsgarage.com
IMAP_PASSWORD=your_password_here
IMAP_SENT_FOLDER=Sent

# Brand Configuration
BRAND_NAME=GMSGARAGE
BRAND_TAGLINE=Premium Oto Galeri
BRAND_WEBSITE=https://gmsgarage.com
BRAND_PHONE=+90 XXX XXX XX XX
BRAND_ADDRESS=İstanbul, Türkiye
LOGO_URL=https://gmsgarage.com/images/light-mode-logo.png
PRIMARY_COLOR=#dc2626
```

### 5. Config Cache Temizleme

```bash
php artisan config:clear
php artisan cache:clear
```

## Kullanım

### Admin Panel Erişimi

1. Admin paneline giriş yapın: `/admin/login`
2. Sol menüden "E-posta Gönder" seçeneğine tıklayın
3. Mail gönderme formunu doldurun:
   - Alıcı E-posta
   - Müşteri Adı
   - Konu
   - İstek Tipi (Opsiyonel)
   - Referans ID (Opsiyonel)
   - Mesaj Metni
4. "Önizleme Göster" butonuna tıklayarak maili önizleyin
5. "E-postayı Gönder" butonuna tıklayın

### Gönderim Kayıtları

- Sol menüden "E-posta Gönder" > "Gönderim Kayıtları" linkine tıklayın
- Son 100 gönderim kaydını görüntüleyebilirsiniz
- Durum: Gönderildi, Başarısız, Beklemede

## Teknik Detaylar

### SMTP Gönderimi

- PHPMailer kullanılarak SMTP üzerinden mail gönderilir
- Hostinger SMTP ayarları: `smtp.hostinger.com:465` (SSL)

### IMAP APPEND

- Gönderilen mail, RFC822 formatında IMAP APPEND komutu ile Sent klasörüne eklenir
- Böylece Hostinger Webmail'de "Gönderilenler" klasöründe görünür
- IMAP bağlantısı: `imap.hostinger.com:993` (SSL)

### HTML Template

- Inline CSS kullanılır (email client uyumluluğu için)
- Mobil uyumlu responsive tasarım
- Kurumsal logo, renk ve footer otomatik eklenir
- XSS koruması: Kullanıcı mesajı `e()` helper ile escape edilir
- Satır sonları `nl2br()` ile `<br>` tag'lerine çevrilir

### Güvenlik

- **XSS Koruması**: Tüm kullanıcı girdileri `e()` ile escape edilir
- **Rate Limit**: Aynı IP'den dakikada maksimum 10 gönderim
- **Input Validation**: Email format kontrolü, zorunlu alanlar
- **CSRF Protection**: Laravel CSRF token koruması

## Hostinger'a Deploy

### 1. Dosyaları Yükle

FTP veya cPanel File Manager ile dosyaları yükleyin.

### 2. Composer Install

SSH erişiminiz varsa:
```bash
cd /path/to/your/project
composer install --no-dev --optimize-autoloader
```

SSH erişiminiz yoksa, `composer install` komutunu local'de çalıştırıp `vendor` klasörünü yükleyin.

### 3. Environment Variables

Hostinger cPanel'den `.env` dosyasını düzenleyin veya FTP ile yükleyin.

### 4. Migration

SSH erişiminiz varsa:
```bash
php artisan migrate --force
```

SSH yoksa, local'de migration'ı çalıştırıp veritabanını yükleyin.

### 5. Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 6. PHP IMAP Extension Kontrolü

Hostinger'da PHP IMAP extension'ının aktif olduğundan emin olun. Genellikle varsayılan olarak yüklüdür.

## Sorun Giderme

### IMAP Bağlantı Hatası

**Hata:** `IMAP bağlantısı kurulamadı`

**Çözüm:**
1. PHP IMAP extension'ının yüklü olduğundan emin olun
2. IMAP_HOST, IMAP_PORT, IMAP_USER, IMAP_PASSWORD ayarlarını kontrol edin
3. Hostinger'da IMAP erişiminin aktif olduğundan emin olun

### SMTP Gönderim Hatası

**Hata:** `SMTP Hatası: Authentication failed`

**Çözüm:**
1. MAIL_USERNAME ve MAIL_PASSWORD'ün doğru olduğundan emin olun
2. MAIL_USERNAME ve MAIL_FROM_ADDRESS'in aynı olması gerekmektedir
3. MAIL_ENCRYPTION'ı `ssl` veya `tls` olarak ayarlayın

### Sent Klasörüne Eklenemiyor

**Hata:** `Sent klasörüne eklenemedi`

**Çözüm:**
1. IMAP_SENT_FOLDER değerini kontrol edin (genellikle "Sent" veya "Gönderilenler")
2. Hostinger'da IMAP erişiminin aktif olduğundan emin olun
3. IMAP_USER ve IMAP_PASSWORD'ün doğru olduğundan emin olun

## Klasör Yapısı

```
app/
├── Http/
│   └── Controllers/
│       └── Admin/
│           └── MailSendController.php    # Mail gönderim controller'ı
├── Models/
│   └── SentEmail.php                     # Gönderim kayıtları modeli
database/
└── migrations/
    └── 2026_02_01_170354_create_sent_emails_table.php
resources/
└── views/
    └── admin/
        └── mail-send/
            ├── index.blade.php           # Mail gönderme formu
            └── logs.blade.php            # Gönderim kayıtları
routes/
└── admin.php                             # Admin routes (mail-send routes eklendi)
config/
└── mail.php                              # Mail config (IMAP ve Brand ayarları eklendi)
```

## API Endpoints

### POST /admin/mail-send/preview
Mail önizlemesi için AJAX endpoint.

**Request:**
```json
{
    "recipient_email": "customer@example.com",
    "subject": "Test Mail",
    "customer_name": "John Doe",
    "request_type": "degerleme_alindi",
    "reference_id": "REF123",
    "message_text": "Test mesajı"
}
```

**Response:**
```json
{
    "success": true,
    "html": "<!DOCTYPE html>..."
}
```

### POST /admin/mail-send/send
Mail gönderimi için form submission.

**Request:** Form data (POST)

**Response:** Redirect with success/error message

## Lisans

Bu proje GMSGARAGE için özel olarak geliştirilmiştir.
