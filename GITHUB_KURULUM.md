# 🚀 GitHub'a İlk Kayıt Adımları

## ⚠️ Durum
Proje şu anda **GitHub'da kayıtlı değil**. Tüm değişiklikler sadece yerel bilgisayarınızda.

## 📋 Adım Adım Kurulum

### 1. Git Kurulumu (Eğer yoksa)

```powershell
# Git'i indir ve kur: https://git-scm.com/download/win
# VEYA winget ile:
winget install Git.Git

# Kurulumdan sonra PowerShell'i kapatıp yeniden açın
```

### 2. GitHub'da Repository Oluştur

1. https://github.com adresine gidin
2. Giriş yapın
3. Sağ üstteki **"+"** butonuna tıklayın → **"New repository"**
4. Repository adı: `gmsgarage` (veya istediğiniz isim)
5. **Public** veya **Private** seçin
6. **"Create repository"** butonuna tıklayın
7. **ÖNEMLİ:** "Initialize this repository with a README" seçeneğini **İŞARETLEMEYİN**

### 3. Yerel Projeyi Git Repository'sine Dönüştür

```powershell
# Proje klasörüne gidin
cd c:\Users\gmskr\Desktop\gmsgarage

# Git repository'sini başlat
git init

# GitHub repository'sini ekle (KULLANICI_ADI yerine GitHub kullanıcı adınızı yazın)
git remote add origin https://github.com/KULLANICI_ADI/gmsgarage.git
```

### 4. İlk Commit ve Push

```powershell
# Tüm dosyaları ekle
git add .

# İlk commit yap
git commit -m "feat: İlk commit - GMSGARAGE projesi

- Laravel 10 tabanlı araç satış platformu
- Ana sayfa, araç listeleme ve detay sayfaları
- Araç değerleme sihirbazı
- İletişim formu
- Çoklu fotoğraf galerisi
- Responsive tasarım
- Tailwind CSS ile modern UI"

# Ana branch'i oluştur
git branch -M main

# GitHub'a push et
git push -u origin main
```

### 5. Son Değişiklikleri Kaydet

```powershell
# Tüm değişiklikleri ekle
git add .

# Commit yap
git commit -m "feat: Araç detay sayfası yeniden tasarlandı ve çoklu fotoğraf galerisi eklendi

- Layout düzenlendi: Sol fotoğraflar, sağ bilgiler, alt teknik özellikler
- Çoklu fotoğraf galerisi eklendi (thumbnail + sayacı + lazy-load)
- İlan tarihi başlık altında gösteriliyor
- Teknik Özellikler kartı alt kısımda (2 sütun)
- VehicleNormalizer helper sınıfı kaldırıldı (gereksiz)
- Test için Unsplash göstermelik fotoğraflar eklendi
- Araç kartlarında ilan tarihi eklendi
- Kod temizliği yapıldı"

# GitHub'a push et
git push
```

## ✅ Kontrol

GitHub'a kaydedildikten sonra kontrol edin:

```powershell
# Remote repository'yi kontrol et
git remote -v

# Son commit'leri görüntüle
git log --oneline -5

# GitHub durumunu kontrol et
git status
```

## 🔄 Gelecekteki Güncellemeler İçin

Her değişiklikten sonra:

```powershell
git add .
git commit -m "feat: Yapılan değişikliklerin açıklaması"
git push
```

## 📌 Önemli Notlar

1. **.env Dosyası:** `.env` dosyası `.gitignore`'da olduğu için GitHub'a yüklenmeyecek (güvenlik)
2. **Database:** `database.sqlite` dosyası commit edilebilir (test için)
3. **node_modules:** Otomatik olarak ignore edilir
4. **vendor:** Otomatik olarak ignore edilir

---

**Durum:** ⚠️ Henüz GitHub'a kaydedilmedi
**Sonraki Adım:** Git kurulumu ve repository oluşturma
