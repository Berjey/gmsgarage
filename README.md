# GMSGARAGE - Premium Oto Galeri Kurumsal Web Sitesi

Modern, şık ve profesyonel tasarıma sahip Laravel 10 tabanlı kurumsal web sitesi.

## 🚀 Hızlı Başlangıç

### Başka Bilgisayarda Devam Etmek İçin

**En Hızlı Yol:**
1. `HIZLI_BASLANGIC.md` dosyasına bakın
2. GitHub/GitLab kullanarak projeyi klonlayın
3. Kurulum adımlarını takip edin

**Detaylı Rehber:**
- `BASKA_BILGISAYARDA_DEVAM.md` - Tam kurulum rehberi
- `GIT_KURULUM.md` - Git kullanımı
- `PROJE_OZET.md` - Proje özeti ve özellikler

## 📋 Gereksinimler

- PHP 8.1 veya üzeri
- Composer
- MySQL 5.7 veya üzeri
- Node.js 16+ ve NPM

## ⚡ Kurulum

```bash
# 1. Bağımlılıkları yükle
composer install
npm install

# 2. Ortam dosyasını oluştur
cp .env.example .env

# 3. .env dosyasını düzenle (veritabanı bilgileri)

# 4. Uygulama anahtarını oluştur
php artisan key:generate

# 5. Veritabanını oluştur ve migration'ları çalıştır
php artisan migrate

# 6. Seed verilerini yükle
php artisan db:seed

# 7. Storage link oluştur
php artisan storage:link

# 8. Frontend build
npm run build

# 9. Sunucuyu başlat
php artisan serve
```

Tarayıcıda `http://localhost:8000` adresine gidin.

## 📁 Proje Yapısı

- **Controllers**: `app/Http/Controllers/`
- **Models**: `app/Models/`
- **Views**: `resources/views/`
- **Routes**: `routes/web.php`
- **Migrations**: `database/migrations/`
- **Services**: `app/Services/` (Faz 2 için hazır)

## 🎨 Özellikler

- ✅ Modern ve şık tasarım (Cesa Yazılım tarzı)
- ✅ Smooth animasyonlar ve transitions
- ✅ Responsive design (mobil uyumlu)
- ✅ SEO-friendly URL yapısı
- ✅ Araç listeleme ve detay sayfaları
- ✅ 4 adımlı araç değerleme sistemi
- ✅ Filtreleme ve arama
- ✅ Sahibinden API hazırlığı (Faz 2)

## 📚 Dokümantasyon

- `HIZLI_BASLANGIC.md` - Hızlı başlangıç rehberi
- `BASKA_BILGISAYARDA_DEVAM.md` - Detaylı kurulum
- `GIT_KURULUM.md` - Git kullanımı
- `PROJE_OZET.md` - Proje özeti
- `KURULUM.md` - Genel kurulum bilgileri

## 🔧 Geliştirme

```bash
# Development mode (hot reload)
npm run dev

# Production build
npm run build
```

## 🔄 Otomatik GitHub Kaydetme

Dosya kaydettikten sonra GitHub'a otomatik push için:

```powershell
# Terminal'de çalıştır
.\OTOMATIK_KAYDET.ps1
```

**VEYA Cursor'da:**
- `Ctrl+Shift+P` → `Tasks: Run Task` → `🔄 Otomatik GitHub Kaydet`

Detaylı kullanım için: `CURSOR_OTOMATIK_KAYDET.md`

## 📝 Notlar

- Bu fazda admin panel yok
- Sahibinden API entegrasyonu altyapı hazır, gerçek entegrasyon Faz 2'de
- Tüm araç verileri veritabanından geliyor (hardcode değil)

## 📄 Lisans

MIT

---

**Son Güncelleme**: 2025-01-15
