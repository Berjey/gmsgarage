# 🕐 Laravel Scheduler Kurulumu (Otomatik Aktivite Log Temizleme)

## 📋 Otomatik Görevler

Sistem, **7 günden eski aktivite loglarını** otomatik olarak her gece saat **02:00**'de temizler.

---

## 🖥️ Windows için Kurulum (Task Scheduler)

### 1. Adım: Task Scheduler'ı Açın
- `Win + R` tuşlarına basın
- `taskschd.msc` yazın ve Enter'a basın

### 2. Adım: Yeni Görev Oluşturun
1. Sağ tarafta **"Create Basic Task"** seçeneğine tıklayın
2. **İsim:** `Laravel Scheduler - GMSGARAGE`
3. **Açıklama:** `Laravel zamanlanmış görevlerini çalıştırır`
4. **Next** butonuna tıklayın

### 3. Adım: Zamanlama Ayarı
1. **Trigger:** `Daily` (Günlük) seçin
2. **Start:** Bugünün tarihini seçin
3. **Recur every:** `1 day` (Her gün)
4. **Next** butonuna tıklayın

### 4. Adım: Aksiyon Ayarı
1. **Action:** `Start a program` seçin
2. **Program/script:** `C:\php\php.exe` (PHP'nizin kurulu olduğu yol)
   - Eğer PHP PATH'de varsa sadece: `php`
3. **Add arguments:** `artisan schedule:run`
4. **Start in:** `C:\Users\Berke\Desktop\gmsgarage` (Proje dizininiz)
5. **Next** ve **Finish** butonlarına tıklayın

### 5. Adım: Ayarları Düzenleyin
1. Task Scheduler'da oluşturduğunuz görevi bulun
2. Sağ tıklayın ve **"Properties"** seçin
3. **Triggers** sekmesine gidin
4. **Edit** butonuna tıklayın
5. **Repeat task every:** `5 minutes` seçin
6. **for a duration of:** `Indefinitely` seçin
7. **OK** butonuna tıklayın

> ⚠️ **Önemli:** Laravel Scheduler'ın düzgün çalışması için her 1-5 dakikada bir çalıştırılması gerekir. Windows Task Scheduler bunu her 5 dakikada bir çalışacak şekilde ayarlayın.

---

## 🐧 Linux için Kurulum (Crontab)

### 1. Adım: Crontab Düzenleme
```bash
crontab -e
```

### 2. Adım: Laravel Scheduler'ı Ekleyin
Aşağıdaki satırı dosyanın sonuna ekleyin:
```bash
* * * * * cd /var/www/gmsgarage && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Adım: Kaydet ve Çık
- `Ctrl + X` ile çıkın
- `Y` ile kaydedin
- `Enter` ile onaylayın

### 4. Adım: Kontrol Edin
```bash
crontab -l
```

---

## ✅ Test Etme

Manuel olarak çalıştırmak için:
```bash
php artisan schedule:run
```

7 günden eski logları şimdi temizlemek için:
```bash
php artisan logs:clean-old
```

---

## 📊 Mevcut Zamanlanmış Görevler

| Görev | Zaman | Açıklama |
|-------|-------|----------|
| `logs:clean-old` | Her gün 02:00 | 7 günden eski aktivite loglarını siler |

---

## 🔍 Sorun Giderme

### Scheduler çalışmıyor mu?

1. **PHP PATH kontrolü:**
   ```bash
   php --version
   ```

2. **Cron log'larını kontrol edin (Linux):**
   ```bash
   grep CRON /var/log/syslog
   ```

3. **Laravel log'larını kontrol edin:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Manuel test:**
   ```bash
   php artisan schedule:run
   ```

---

## 📝 Notlar

- Windows'ta **Task Scheduler** kullanıyorsanız, bilgisayarınız kapalıyken görevler çalışmaz.
- Linux sunucularda cron daemon'ı sürekli çalışır.
- Shared hosting kullanıyorsanız, hosting sağlayıcınızın cPanel'inden cron job ekleyebilirsiniz.

---

## 🎯 İpuçları

- Aktivite loglarını **manuel temizlemek** için Admin Panel > Aktivite Logları sayfasındaki butonları kullanın.
- Otomatik temizleme **7 gün** olarak ayarlıdır. Bu süreyi değiştirmek için `app/Console/Commands/CleanOldActivityLogs.php` dosyasını düzenleyin.
- Tüm zamanlanmış görevleri görmek için: `php artisan schedule:list`

---

**Hazırlayan:** GMSGARAGE Geliştirme Ekibi  
**Tarih:** Şubat 2026
