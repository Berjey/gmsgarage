# GMSGARAGE - Premium Oto Galeri Kurumsal Web Sitesi

Modern, şık ve profesyonel tasarıma sahip Laravel 10 tabanlı kurumsal web sitesi.

## 🚀 Hızlı Başlangıç

### Başka Bilgisayarda Devam Etmek İçin

```bash
# Projeyi klonla
git clone https://github.com/Berjey/gmsgarage.git
cd gmsgarage

# Kurulum adımlarını takip edin (aşağıdaki Kurulum bölümüne bakın)
```

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



## 🔧 Geliştirme

```bash
# Development mode (hot reload)
npm run dev

# Production build
npm run build
```

## 📝 Özellikler

### Genel Özellikler
- ✅ Modern ve şık tasarım
- ✅ Smooth animasyonlar ve transitions
- ✅ Responsive design (mobil uyumlu)
- ✅ SEO-friendly URL yapısı
- ✅ Dark Mode desteği (OS algılama + manuel toggle)
- ✅ Light Mode (varsayılan)

### İçerik Yönetimi
- ✅ Araç listeleme ve detay sayfaları
- ✅ Blog sistemi (kategoriler, SEO optimizasyonu)
- ✅ Sayfa yönetimi (Hakkımızda, İletişim, KVKK, vb.)
- ✅ Görsel yükleme ve yönetimi
- ✅ Medya kütüphanesi

### Admin Paneli
- ✅ Kapsamlı admin paneli
- ✅ Araç yönetimi (CRUD)
- ✅ Blog yönetimi (CRUD)
- ✅ Sayfa yönetimi
- ✅ Kullanıcı yönetimi
- ✅ Site ayarları
- ✅ Form mesajları yönetimi (İletişim, Araç İsteği, Değerleme)
- ✅ Gelişmiş dashboard ve istatistikler

### Formlar
- ✅ 4 adımlı araç değerleme sistemi
- ✅ İletişim formu
- ✅ Araç istek formu
- ✅ Filtreleme ve arama

## 🔐 Admin Panel Giriş

- **URL**: `http://localhost:8000/admin/login`
- **E-posta**: `admin@gmsgarage.com`
- **Şifre**: `admin123`

## 📝 Notlar

- Sahibinden API entegrasyonu altyapı hazır (Faz 2 için)
- Tüm veriler veritabanından geliyor
- Görseller `storage/app/public` klasöründe saklanıyor

## 📄 Lisans

MIT

---

**Son Güncelleme**: 2026-01-18
