# Git Kurulumu ve Kullanımı

## 🚀 Hızlı Başlangıç

### 1. Git Yapılandırması (İlk Kez Kullanıyorsanız)

```bash
# Git kullanıcı bilgilerinizi ayarlayın
git config --global user.name "Adınız Soyadınız"
git config --global user.email "email@example.com"

# Veya sadece bu proje için:
git config user.name "Adınız Soyadınız"
git config user.email "email@example.com"
```

### 2. İlk Commit

```bash
# Tüm dosyaları ekle
git add .

# Commit yap
git commit -m "Initial commit: GMSGARAGE projesi tamamlandı"
```

### 3. GitHub/GitLab'a Yükleme

**GitHub için:**

1. GitHub'da yeni repository oluşturun: https://github.com/new
2. Repository adı: `gmsgarage`
3. Public veya Private seçin
4. **"Initialize with README" seçmeyin** (zaten var)
5. Oluşturduktan sonra şu komutları çalıştırın:

```bash
git remote add origin https://github.com/KULLANICI_ADI/gmsgarage.git
git branch -M main
git push -u origin main
```

**GitLab için:**

1. GitLab'da yeni project oluşturun
2. Şu komutları çalıştırın:

```bash
git remote add origin https://gitlab.com/KULLANICI_ADI/gmsgarage.git
git branch -M main
git push -u origin main
```

## 📝 Günlük Kullanım

### Değişiklikleri Kaydetme

```bash
# Değişiklikleri kontrol et
git status

# Değişiklikleri ekle
git add .

# Commit yap
git commit -m "Yapılan değişikliklerin açıklaması"

# GitHub/GitLab'a gönder
git push
```

### Başka Bilgisayarda Güncelleme

```bash
# Son değişiklikleri çek
git pull
```

## 🔄 Yeni Bilgisayarda İlk Kurulum

```bash
# Projeyi klonla
git clone https://github.com/KULLANICI_ADI/gmsgarage.git
cd gmsgarage

# Sonra normal kurulum adımlarını takip edin
# (BASKA_BILGISAYARDA_DEVAM.md dosyasına bakın)
```

## ⚠️ Önemli Notlar

- `.env` dosyası Git'e eklenmez (güvenlik)
- `vendor/` ve `node_modules/` Git'e eklenmez (yeniden yüklenir)
- `storage/framework/views/` Git'e eklenmez (otomatik oluşur)
