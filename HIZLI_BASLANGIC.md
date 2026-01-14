# 🚀 Hızlı Başlangıç - Başka Bilgisayarda Devam Etme

## ⚡ En Hızlı Yol (GitHub/GitLab Kullanarak)

### Mevcut Bilgisayarda (İlk Kez):

```bash
# 1. Git yapılandırması (sadece ilk kez)
git config --global user.name "Adınız"
git config --global user.email "email@example.com"

# 2. Tüm dosyaları ekle ve commit yap
git add .
git commit -m "Initial commit: GMSGARAGE projesi"

# 3. GitHub'da repository oluştur (github.com/new)
# 4. Repository'yi bağla ve gönder
git remote add origin https://github.com/KULLANICI_ADI/gmsgarage.git
git branch -M main
git push -u origin main
```

### Yeni Bilgisayarda:

```bash
# 1. Projeyi klonla
git clone https://github.com/KULLANICI_ADI/gmsgarage.git
cd gmsgarage

# 2. .env dosyasını oluştur
cp .env.example .env

# 3. .env dosyasını düzenle (veritabanı bilgileri)
# DB_DATABASE=gmsgarage
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Kurulum komutları
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build

# 5. Çalıştır
php artisan serve
```

---

## 📦 Manuel Transfer (Git Kullanmıyorsanız)

### Mevcut Bilgisayarda:

1. **Tüm proje klasörünü** USB/Cloud'a kopyalayın
2. **ÖNEMLİ:** `.env` dosyasını **AYRI** olarak kaydedin
3. `node_modules` ve `vendor` klasörlerini **KOPYALAMAYIN**

### Yeni Bilgisayarda:

1. Proje klasörünü kopyalayın
2. `.env` dosyasını proje klasörüne koyun
3. Yeni bilgisayarda kurulum adımlarını takip edin (yukarıdaki 4-5. adımlar)

---

## ✅ Kontrol Listesi

### Yeni Bilgisayarda Gereksinimler:
- [ ] PHP 8.1+ yüklü (`php -v`)
- [ ] Composer yüklü (`composer --version`)
- [ ] MySQL yüklü ve çalışıyor
- [ ] Node.js 16+ yüklü (`node -v`)
- [ ] NPM yüklü (`npm -v`)

### Kurulum Adımları:
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

## 📚 Detaylı Rehberler

- **`BASKA_BILGISAYARDA_DEVAM.md`** - Detaylı kurulum rehberi
- **`GIT_KURULUM.md`** - Git kullanımı
- **`PROJE_OZET.md`** - Proje özeti ve özellikler
- **`README.md`** - Genel proje bilgileri

---

## 🔧 Sorun Giderme

**"composer command not found"**
→ Composer'ı [getcomposer.org](https://getcomposer.org/download/) adresinden indirin

**"php command not found"**
→ PHP'yi PATH'e ekleyin veya tam yol ile kullanın

**"Unknown database 'gmsgarage'"**
→ MySQL'de veritabanını oluşturun: `CREATE DATABASE gmsgarage;`

**"npm command not found"**
→ Node.js'i [nodejs.org](https://nodejs.org/) adresinden indirin

---

**Son Güncelleme**: 2025-01-15
