# 🚀 GitHub'a Yükleme Rehberi

## Adım 1: GitHub'da Repository Oluşturma

1. **GitHub'a giriş yapın**: https://github.com
2. **Yeni repository oluşturun**: https://github.com/new
3. **Repository bilgileri:**
   - Repository name: `gmsgarage` (veya istediğiniz isim)
   - Description: `GMSGARAGE - Premium Oto Galeri Kurumsal Web Sitesi`
   - Public veya Private seçin
   - ⚠️ **"Initialize with README" seçmeyin** (zaten var)
   - ⚠️ **"Add .gitignore" seçmeyin** (zaten var)
   - ⚠️ **"Choose a license" seçmeyin** (opsiyonel)
4. **"Create repository" butonuna tıklayın**

## Adım 2: Projeyi GitHub'a Yükleme

Repository oluşturduktan sonra, GitHub size komutlar gösterecek. Şu komutları çalıştırın:

```bash
# Remote repository'yi ekle (KULLANICI_ADI'ni değiştirin)
git remote add origin https://github.com/KULLANICI_ADI/gmsgarage.git

# Branch adını main yap
git branch -M main

# GitHub'a yükle
git push -u origin main
```

**Eğer GitHub'da zaten README varsa:**
```bash
git pull origin main --allow-unrelated-histories
git push -u origin main
```

## Adım 3: Kontrol

GitHub'da repository'nize gidin ve tüm dosyaların yüklendiğini kontrol edin.

---

## 🔄 Gelecekte Değişiklikleri Yükleme

Her değişiklik yaptığınızda:

```bash
# Değişiklikleri kontrol et
git status

# Tüm değişiklikleri ekle
git add .

# Commit yap (açıklayıcı mesaj ile)
git commit -m "Yapılan değişikliklerin açıklaması"

# GitHub'a gönder
git push
```

### Örnek Commit Mesajları:

```bash
git commit -m "Ana sayfa tasarımı iyileştirildi"
git commit -m "Araç detay sayfasına yeni özellikler eklendi"
git commit -m "Responsive tasarım düzeltmeleri"
git commit -m "Animasyonlar optimize edildi"
```

---

## 📥 Başka Bilgisayarda Güncelleme

```bash
# Son değişiklikleri çek
git pull

# Veya tüm projeyi klonla (yeni bilgisayarda)
git clone https://github.com/KULLANICI_ADI/gmsgarage.git
cd gmsgarage
```

---

## ⚙️ Git Yapılandırması (İlk Kez)

Eğer Git kullanıcı bilgileriniz yoksa:

```bash
git config --global user.name "Adınız Soyadınız"
git config --global user.email "email@example.com"
```

---

## 🔐 Güvenlik

- ✅ `.env` dosyası Git'e eklenmez (güvenlik)
- ✅ `vendor/` ve `node_modules/` Git'e eklenmez
- ✅ Storage klasörü Git'e eklenmez

---

## 📝 Notlar

- Her commit'te açıklayıcı mesaj yazın
- Büyük değişikliklerden önce `git status` ile kontrol edin
- Önemli değişikliklerden önce yedek alın

---

**Son Güncelleme**: 2025-01-15
