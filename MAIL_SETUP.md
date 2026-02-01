# Mail Konfigürasyonu - Hostinger SMTP

Bu dosya, Hostinger SMTP ayarlarını yapılandırmak için gereken bilgileri içerir.

## ⚠️ ÖNEMLİ: "530 Authentication required" Hatası

Bu hata, SMTP kimlik doğrulama sorununu gösterir. **ÇÖZÜM:**

1. **MAIL_USERNAME ve MAIL_FROM_ADDRESS AYNI OLMALI**
2. **MAIL_PASSWORD doğru olmalı**
3. **Hostinger'da e-posta hesabı aktif olmalı**

## .env Dosyası Ayarları

Hostinger SMTP kullanmak için `.env` dosyanıza aşağıdaki ayarları ekleyin:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@gmsgarage.com
MAIL_PASSWORD=your-email-password-here
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@gmsgarage.com
MAIL_FROM_NAME="GMSGARAGE"
```

### ⚠️ KRİTİK KURAL:
- `MAIL_USERNAME` ve `MAIL_FROM_ADDRESS` **MUTLAKA AYNI** olmalı
- Örnek: İkisi de `info@gmsgarage.com` olmalı
- Farklı olursa "530 Authentication required" hatası alırsınız

## Hostinger SMTP Ayarları

### Port ve Şifreleme Seçenekleri:

**Seçenek 1: SSL ile Port 465 (Önerilen)**
```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

**Seçenek 2: TLS ile Port 587**
```env
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

**Seçenek 3: TLS ile Port 25**
```env
MAIL_PORT=25
MAIL_ENCRYPTION=tls
```

## Hostinger'da E-posta Hesabı Oluşturma

1. Hostinger kontrol paneline giriş yapın
2. **E-postalar** bölümüne gidin
3. **Yeni E-posta Adresi Oluştur** seçeneğini seçin
4. E-posta adresini oluşturun (örn: `info@gmsgarage.com`)
5. Güçlü bir şifre belirleyin
6. Şifreyi `.env` dosyasındaki `MAIL_PASSWORD` alanına yapıştırın

## Önemli Notlar

1. **E-posta Adresi**: `MAIL_USERNAME` ve `MAIL_FROM_ADDRESS` aynı olmalıdır (Hostinger'da oluşturduğunuz e-posta adresi).

2. **Şifre**: Hostinger'da oluşturduğunuz e-posta hesabının şifresini kullanın.

3. **Domain**: E-posta adresiniz, Hostinger'da barındırdığınız domain ile eşleşmelidir.

4. **Test**: Ayarları yaptıktan sonra, admin panelinden bir test e-postası göndererek kontrol edin.

## Sorun Giderme

### "530 5.7.1 Authentication required" Hatası

**Çözüm:**
1. `.env` dosyasında `MAIL_USERNAME` ve `MAIL_FROM_ADDRESS` aynı mı kontrol edin
2. `MAIL_PASSWORD` doğru mu kontrol edin
3. Hostinger'da e-posta hesabının aktif olduğundan emin olun
4. Config cache'i temizleyin: `php artisan config:clear`

**Örnek Doğru Ayarlar:**
```env
MAIL_USERNAME=info@gmsgarage.com
MAIL_FROM_ADDRESS=info@gmsgarage.com
MAIL_PASSWORD=GüçlüŞifre123!
```

### "Connection timeout" hatası

- Port 465 yerine 587 deneyin
- SSL yerine TLS deneyin
- Firewall ayarlarınızı kontrol edin

### "Authentication failed" hatası

- Kullanıcı adı ve şifrenin doğru olduğundan emin olun
- E-posta hesabının Hostinger'da aktif olduğundan emin olun
- `MAIL_USERNAME` ve `MAIL_FROM_ADDRESS` aynı olmalı

### "Sender address rejected" hatası

- `MAIL_FROM_ADDRESS` doğrulanmamış → Domain'e ait email kullan
- SPF/DMARC hatası → `no-reply@gmsgarage.com` gibi domain'e ait adres kullan

### Mail Gönderiliyor Ama Inbox'a Gelmiyor

1. **Spam klasörünü kontrol et**
2. **SPF/DKIM kayıtlarını kontrol et** (Hostinger DNS ayarları)
3. **Mail log'larını incele:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

## Laravel Cache Temizleme

Ayarları değiştirdikten sonra cache'i temizleyin:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Test Komutu

E-posta gönderimini test etmek için:

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

## Kontrol Listesi

E-posta göndermeden önce kontrol edin:

- [ ] `.env` dosyasında `MAIL_USERNAME` ayarlı
- [ ] `.env` dosyasında `MAIL_PASSWORD` ayarlı
- [ ] `MAIL_USERNAME` ve `MAIL_FROM_ADDRESS` **AYNI**
- [ ] `MAIL_HOST` = `smtp.hostinger.com`
- [ ] `MAIL_PORT` = `465` veya `587`
- [ ] `MAIL_ENCRYPTION` = `ssl` veya `tls`
- [ ] Hostinger'da e-posta hesabı aktif
- [ ] Config cache temizlendi: `php artisan config:clear`

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
- ✅ `MAIL_USERNAME` ve `MAIL_FROM_ADDRESS` **MUTLAKA AYNI** olmalı
- ✅ Spam olmamak için SPF/DKIM/DMARC DNS kayıtları ayarla
- ✅ Test mail'i kendi emailine gönder
- ✅ Production'da `config:cache` çalıştır

## 🎯 SONUÇ

Tüm adımlar tamamlandığında:
- 🟢 SMTP kimlik doğrulama çalışıyor
- 🟢 E-posta gönderimi başarılı
- 🟢 Hostinger inbox'a mail düşüyor

---

**Not:** Herhangi bir sorun olursa `storage/logs/laravel.log` dosyasını kontrol edin!
