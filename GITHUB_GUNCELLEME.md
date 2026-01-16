# 🚀 GitHub Güncelleme Talimatları

## ⚠️ Durum
Git yüklü değil. GitHub'a push yapmak için önce Git kurulumu yapmanız gerekiyor.

## 📋 Hızlı Çözüm

### Seçenek 1: Git Bash Kullan (Eğer Git yüklüyse ama PATH'te değilse)

1. **Git Bash**'i açın (Başlat menüsünde "Git Bash" arayın)
2. Şu komutları çalıştırın:

```bash
cd /c/Users/gmskr/Desktop/gmsgarage

# Durumu kontrol et
git status

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
- Kod temizliği yapıldı
- GITHUB_KURULUM.md ve PROJE_DURUMU.md dokümantasyon dosyaları eklendi"

# GitHub'a push et
git push origin main
```

### Seçenek 2: Git Kurulumu Yap

1. **Git'i indirin:** https://git-scm.com/download/win
2. **Kurulumu yapın** (varsayılan ayarlarla)
3. **PowerShell'i kapatıp yeniden açın**
4. Şu komutları çalıştırın:

```powershell
cd c:\Users\gmskr\Desktop\gmsgarage

# Durumu kontrol et
git status

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
- Kod temizliği yapıldı
- GITHUB_KURULUM.md ve PROJE_DURUMU.md dokümantasyon dosyaları eklendi"

# GitHub'a push et
git push origin main
```

### Seçenek 3: GitHub Desktop Kullan

1. **GitHub Desktop'ı indirin:** https://desktop.github.com/
2. **Kurulumu yapın**
3. **Repository'yi açın:** `File` → `Add Local Repository` → `c:\Users\gmskr\Desktop\gmsgarage`
4. **Değişiklikleri commit edin:**
   - Sol tarafta değişiklikleri görün
   - Alt kısımda commit mesajı yazın
   - "Commit to main" butonuna tıklayın
5. **Push edin:** "Push origin" butonuna tıklayın

## ✅ Kontrol

GitHub'a push yaptıktan sonra kontrol edin:

1. https://github.com/Berjey/gmsgarage adresine gidin
2. Son commit'in göründüğünü kontrol edin
3. Dosyaların güncellendiğini kontrol edin

## 🏠 Evdeki Bilgisayarda Devam Etmek İçin

```powershell
# 1. Repository'yi klonla
git clone https://github.com/Berjey/gmsgarage.git
cd gmsgarage

# 2. Dependencies'leri yükle
composer install
npm install

# 3. .env dosyasını oluştur
copy .env.example .env
php artisan key:generate

# 4. Database'i oluştur (eğer yoksa)
php artisan migrate
php artisan db:seed

# 5. Frontend build
npm run build

# 6. Server'ı başlat
php artisan serve
```

---

**Durum:** ⚠️ Git kurulumu gerekli
**Repository:** https://github.com/Berjey/gmsgarage
**Sonraki Adım:** Git kurulumu ve push işlemi
