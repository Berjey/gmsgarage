# Başka Bilgisayarda Devam Etme Rehberi

Bu rehber, GMSGARAGE projesine başka bir bilgisayarda devam edebilmeniz için gerekli tüm adımları içerir.

## 📋 İçindekiler

1. [Mevcut Bilgisayarda Yapılacaklar](#1-mevcut-bilgisayarda-yapılacaklar)
2. [Yeni Bilgisayarda Kurulum](#2-yeni-bilgisayarda-kurulum)
3. [Hızlı Başlangıç](#3-hızlı-başlangıç)

---

## 1. Mevcut Bilgisayarda Yapılacaklar

### A. Git Repository Oluşturma

Eğer Git repository yoksa:

```bash
# Git yapılandırması (ilk kez)
git config --global user.name "Adınız Soyadınız"
git config --global user.email "email@example.com"

# Git repository başlat
git init

# Tüm dosyaları ekle
git add .

# İlk commit
git commit -m "Initial commit: GMSGARAGE projesi tamamlandı"
```

### B. GitHub/GitLab'a Yükleme (Önerilen)

**GitHub kullanıyorsanız:**

1. GitHub'da yeni repository oluşturun: https://github.com/new
2. Repository adı: `gmsgarage`
3. Public veya Private seçin
4. **"Initialize with README" seçmeyin**
5. Oluşturduktan sonra şu komutları çalıştırın:

```bash
git remote add origin https://github.com/KULLANICI_ADI/gmsgarage.git
git branch -M main
git push -u origin main
```

**GitLab kullanıyorsanız:**

```bash
# GitLab'da yeni project oluşturun
# Sonra şu komutları çalıştırın:

git remote add origin https://gitlab.com/KULLANICI_ADI/gmsgarage.git
git branch -M main
git push -u origin main
```

### C. Manuel Dosya Transferi (Alternatif)

Eğer Git kullanmak istemiyorsanız:

1. **Tüm proje klasörünü** USB/Cloud'a kopyalayın
2. **ÖNEMLİ:** `.env` dosyasını **AYRI** olarak kaydedin (güvenlik için)
3. `node_modules` ve `vendor` klasörlerini **KOPYALAMAYIN** (yeniden yüklenecek)

---

## 2. Yeni Bilgisayarda Kurulum

### A. Gereksinimler

Yeni bilgisayarda şunların yüklü olması gerekir:

- ✅ **PHP 8.1+** ([php.net](https://www.php.net/downloads.php))
- ✅ **Composer** ([getcomposer.org](https://getcomposer.org/download/))
- ✅ **MySQL 5.7+** veya **MariaDB**
- ✅ **Node.js 16+** ve **NPM** ([nodejs.org](https://nodejs.org/))
- ✅ **Git** (GitHub/GitLab kullanıyorsanız)

### B. Projeyi İndirme

**GitHub/GitLab kullanıyorsanız:**

```bash
# Projeyi klonla
git clone https://github.com/KULLANICI_ADI/gmsgarage.git
# veya
git clone https://gitlab.com/KULLANICI_ADI/gmsgarage.git

# Proje klasörüne gir
cd gmsgarage
```

**Manuel transfer yaptıysanız:**

1. Proje klasörünü istediğiniz yere kopyalayın
2. Terminal/CMD'de proje klasörüne gidin:
```bash
cd C:\Users\KULLANICI\Desktop\gmsgarage
```

### C. Ortam Dosyasını Oluşturma

```bash
# .env.example'dan .env oluştur
cp .env.example .env

# Veya Windows'ta:
copy .env.example .env
```

**`.env` dosyasını düzenleyin:**

```env
APP_NAME=GMSGARAGE
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gmsgarage
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
```

### D. Kurulum Adımları

#### 1. Composer Bağımlılıklarını Yükle

```bash
composer install
```

**Sorun yaşarsanız:**
```bash
composer install --ignore-platform-req=ext-fileinfo
```

#### 2. Uygulama Anahtarını Oluştur

```bash
php artisan key:generate
```

#### 3. Veritabanını Oluştur

MySQL'de yeni veritabanı oluşturun:

```sql
CREATE DATABASE gmsgarage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Veya phpMyAdmin/MySQL Workbench kullanarak manuel oluşturun.

#### 4. Veritabanı Migration'larını Çalıştır

```bash
php artisan migrate
```

#### 5. Seed Verilerini Yükle (Dummy Araçlar)

```bash
php artisan db:seed
```

Bu komut 6 adet örnek araç oluşturacaktır.

#### 6. Storage Link Oluştur

```bash
php artisan storage:link
```

#### 7. NPM Bağımlılıklarını Yükle

```bash
npm install
```

#### 8. Frontend Assets'i Build Et

**Production için:**
```bash
npm run build
```

**Development için (hot reload):**
```bash
npm run dev
```

#### 9. Sunucuyu Başlat

```bash
php artisan serve
```

Tarayıcıda `http://localhost:8000` adresine gidin.

---

## 3. Hızlı Başlangıç

Tüm adımları tek seferde çalıştırmak için:

```bash
# 1. Projeyi klonla (GitHub/GitLab kullanıyorsanız)
git clone https://github.com/KULLANICI_ADI/gmsgarage.git
cd gmsgarage

# 2. .env dosyasını oluştur ve düzenle
cp .env.example .env
# .env dosyasını düzenleyin (veritabanı bilgileri)

# 3. Kurulum komutları
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build

# 4. Sunucuyu başlat
php artisan serve
```

---

## 🔧 Sorun Giderme

### Composer Hatası

**"composer command not found"**
- Composer'ı [getcomposer.org](https://getcomposer.org/download/) adresinden indirip kurun

**"ext-fileinfo missing"**
```bash
composer install --ignore-platform-req=ext-fileinfo
```

### PHP Hatası

**"php command not found"**
- PHP'yi PATH'e ekleyin veya tam yol ile kullanın:
```bash
C:\php\php.exe artisan serve
```

### MySQL Hatası

**"Unknown database 'gmsgarage'"**
- MySQL'de veritabanını oluşturun:
```sql
CREATE DATABASE gmsgarage;
```

### NPM Hatası

**"npm command not found"**
- Node.js'i [nodejs.org](https://nodejs.org/) adresinden indirip kurun

### Build Hatası

**"Vite build failed"**
```bash
# node_modules'ı sil ve yeniden yükle
rm -rf node_modules
# Windows'ta:
Remove-Item -Recurse -Force node_modules
npm install
npm run build
```

---

## 📁 Önemli Dosyalar

### Mutlaka Yedeklenmeli:
- ✅ Tüm `app/` klasörü
- ✅ Tüm `resources/` klasörü
- ✅ Tüm `routes/` klasörü
- ✅ Tüm `database/` klasörü
- ✅ `composer.json`
- ✅ `package.json`
- ✅ `tailwind.config.js`
- ✅ `vite.config.js`
- ✅ `.gitignore`
- ✅ `README.md`

### Yedeklenmemeli (Yeniden Oluşturulacak):
- ❌ `vendor/` (composer install ile)
- ❌ `node_modules/` (npm install ile)
- ❌ `public/build/` (npm run build ile)
- ❌ `.env` (güvenlik için ayrı saklayın)
- ❌ `storage/framework/views/` (otomatik oluşur)
- ❌ `storage/logs/` (otomatik oluşur)

---

## 🔐 Güvenlik Notları

1. **`.env` dosyasını asla Git'e commit etmeyin**
2. Veritabanı şifrelerini güvenli tutun
3. Production'da `APP_DEBUG=false` yapın
4. `APP_KEY` her bilgisayarda farklı olacak (normal)

---

## 📝 Notlar

- Logo dosyası: `public/images/logo.png` (yoksa header'da yazı görünür)
- Araç görselleri: `public/images/vehicles/` (opsiyonel)
- Tüm kod değişiklikleri `app/` ve `resources/` klasörlerinde
- Veritabanı değişiklikleri `database/migrations/` klasöründe

---

## ✅ Kurulum Kontrol Listesi

- [ ] PHP 8.1+ yüklü
- [ ] Composer yüklü
- [ ] MySQL yüklü ve çalışıyor
- [ ] Node.js ve NPM yüklü
- [ ] Proje klasörüne gidildi
- [ ] `.env` dosyası oluşturuldu ve düzenlendi
- [ ] `composer install` çalıştırıldı
- [ ] `php artisan key:generate` çalıştırıldı
- [ ] Veritabanı oluşturuldu
- [ ] `php artisan migrate` çalıştırıldı
- [ ] `php artisan db:seed` çalıştırıldı
- [ ] `npm install` çalıştırıldı
- [ ] `npm run build` çalıştırıldı
- [ ] `php artisan serve` ile test edildi

---

**Son Güncelleme**: 2025-01-15
