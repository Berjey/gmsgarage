# Diğer Bilgisayarda Projeyi Açma Rehberi

## Senaryo 1: Proje İlk Kez Klonlanıyorsa

```bash
# 1. Projeyi klonla
git clone https://github.com/Berjey/gmsgarage.git
cd gmsgarage

# 2. Remote'u kontrol et
git remote -v
# Çıktı şöyle olmalı:
# origin  https://github.com/Berjey/gmsgarage.git (fetch)
# origin  https://github.com/Berjey/gmsgarage.git (push)

# 3. Bağımlılıkları yükle
composer install
npm install

# 4. Environment dosyasını oluştur
cp .env.example .env
php artisan key:generate

# 5. Veritabanını ayarla ve migrate et
php artisan migrate

# 6. Cache'leri temizle
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## Senaryo 2: Proje Zaten Var Ama Güncel Değil

```bash
# 1. Proje klasörüne git
cd gmsgarage

# 2. Remote'u kontrol et
git remote -v
# Eğer remote yoksa veya yanlışsa:
git remote set-url origin https://github.com/Berjey/gmsgarage.git

# 3. Tüm değişiklikleri al
git fetch origin

# 4. Main branch'e geç
git checkout main

# 5. Güncellemeleri çek
git pull origin main

# 6. Bağımlılıkları güncelle
composer install
npm install

# 7. Cache'leri temizle
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## Senaryo 3: "Herhangi Bir Push Yok" Hatası Alıyorsan

Bu hata genellikle şu durumlardan kaynaklanır:

### A) Remote Bağlantısı Yok
```bash
# Remote'u kontrol et
git remote -v

# Eğer boşsa, ekle:
git remote add origin https://github.com/Berjey/gmsgarage.git

# Veya mevcut remote'u güncelle:
git remote set-url origin https://github.com/Berjey/gmsgarage.git
```

### B) Branch Tracking Ayarlanmamış
```bash
# Mevcut branch'i kontrol et
git branch -vv

# Eğer [origin/main] yoksa:
git branch --set-upstream-to=origin/main main

# Veya:
git push -u origin main
```

### C) GitHub'dan Güncellemeleri Çek
```bash
# Önce fetch yap
git fetch origin

# Sonra pull yap
git pull origin main

# Veya tüm branch'leri çek
git pull --all
```

## Kontrol Komutları

```bash
# Remote'u kontrol et
git remote -v

# Branch durumunu kontrol et
git branch -vv

# Son commit'leri gör
git log --oneline -10

# GitHub'daki son commit'leri gör
git log --oneline origin/main -10

# Local ve remote arasındaki farkı gör
git log HEAD..origin/main

# Tüm değişiklikleri gör
git status
```

## Sorun Giderme

### Eğer "fatal: not a git repository" hatası alıyorsan:
```bash
# Proje klasöründe olduğundan emin ol
cd gmsgarage

# Git repository'si olup olmadığını kontrol et
ls -la .git
```

### Eğer "permission denied" hatası alıyorsan:
- GitHub hesabına giriş yap
- SSH key'lerini kontrol et veya HTTPS kullan

### Eğer "branch is behind" uyarısı alıyorsan:
```bash
git pull origin main
```

## Önemli Notlar

1. **Her zaman `git pull` yapmadan önce `git fetch` yap** - Bu, remote'daki değişiklikleri görmeni sağlar
2. **Local değişikliklerin varsa önce commit et veya stash et**
3. **Conflict'ler varsa çöz, sonra commit et**

## Hızlı Komut Seti (Tümünü Sırayla Çalıştır)

```bash
cd gmsgarage
git remote set-url origin https://github.com/Berjey/gmsgarage.git
git fetch origin
git checkout main
git pull origin main
composer install
npm install
php artisan view:clear
php artisan route:clear
php artisan config:clear
```
