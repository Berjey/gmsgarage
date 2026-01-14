# 🚀 Başka Bilgisayarda Devam Etmek İçin

## ⚡ En Hızlı Yol

### 1️⃣ Mevcut Bilgisayarda (Şimdi Yapın)

```bash
# Git yapılandırması (sadece ilk kez)
git config --global user.name "Adınız"
git config --global user.email "email@example.com"

# Commit yap
git add .
git commit -m "Initial commit: GMSGARAGE projesi"

# GitHub'da repository oluştur (github.com/new)
# Sonra:
git remote add origin https://github.com/KULLANICI_ADI/gmsgarage.git
git branch -M main
git push -u origin main
```

### 2️⃣ Yeni Bilgisayarda

```bash
# Projeyi klonla
git clone https://github.com/KULLANICI_ADI/gmsgarage.git
cd gmsgarage

# Kurulum
cp .env.example .env
# .env dosyasını düzenle (veritabanı bilgileri)

composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build

# Çalıştır
php artisan serve
```

---

## 📚 Detaylı Rehberler

- **`HIZLI_BASLANGIC.md`** - Hızlı başlangıç
- **`BASKA_BILGISAYARDA_DEVAM.md`** - Detaylı kurulum
- **`GIT_KURULUM.md`** - Git kullanımı

---

**Git kullanmıyorsanız:** Tüm proje klasörünü USB/Cloud'a kopyalayın (`.env` dosyasını ayrı saklayın)
