# 🖥️ Başka Bilgisayarda Cursor'da Projeyi Açma Rehberi

## ⚡ Hızlı Adımlar (5 Dakika)

### 1️⃣ GitHub'dan Projeyi İndir

**Cursor Terminal'de (veya PowerShell/CMD'de):**

```bash
# İstediğiniz klasöre gidin (örnek: Desktop)
cd Desktop

# Projeyi klonlayın
git clone https://github.com/Berjey/gmsgarage.git

# Proje klasörüne girin
cd gmsgarage
```

### 2️⃣ Cursor'da Projeyi Aç

**İki Yol:**

**Yol 1: Cursor'dan Aç**
1. Cursor'u açın
2. `File` → `Open Folder` (veya `Ctrl+K Ctrl+O`)
3. `gmsgarage` klasörünü seçin
4. `Select Folder` tıklayın

**Yol 2: Terminal'den Aç**
```bash
# Cursor'u proje klasöründe aç
cursor .
```

### 3️⃣ .env Dosyasını Oluştur

**Cursor Terminal'de:**

```bash
# .env.example'dan .env oluştur
cp .env.example .env
```

**VEYA Windows PowerShell'de:**
```powershell
Copy-Item .env.example .env
```

### 4️⃣ .env Dosyasını Düzenle

**Cursor'da `.env` dosyasını açın ve şunları düzenleyin:**

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
DB_PASSWORD=          # MySQL şifrenizi yazın (yoksa boş bırakın)

SESSION_DRIVER=database
```

**ÖNEMLİ:** `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` değerlerini kendi MySQL ayarlarınıza göre düzenleyin!

### 5️⃣ Kurulum Komutlarını Çalıştır

**Cursor Terminal'de (sırayla):**

```bash
# 1. PHP bağımlılıklarını yükle
composer install

# 2. Uygulama anahtarını oluştur
php artisan key:generate

# 3. Veritabanını oluştur (MySQL'de)
# MySQL'de şu komutu çalıştırın:
# CREATE DATABASE gmsgarage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 4. Migration'ları çalıştır
php artisan migrate

# 5. Dummy verileri yükle
php artisan db:seed

# 6. Storage link oluştur
php artisan storage:link

# 7. Node.js bağımlılıklarını yükle
npm install

# 8. Frontend'i build et
npm run build
```

### 6️⃣ Projeyi Çalıştır

```bash
php artisan serve
```

**Tarayıcıda açın:** http://localhost:8000

---

## 📋 Detaylı Adımlar

### Ön Gereksinimler Kontrolü

**Cursor Terminal'de kontrol edin:**

```bash
# PHP versiyonu (8.1+ olmalı)
php -v

# Composer yüklü mü?
composer --version

# Node.js versiyonu (16+ olmalı)
node -v

# NPM yüklü mü?
npm -v

# MySQL çalışıyor mu?
# (MySQL Workbench veya phpMyAdmin'den kontrol edin)
```

**Eksikse yükleyin:**
- PHP: https://www.php.net/downloads.php
- Composer: https://getcomposer.org/download/
- Node.js: https://nodejs.org/
- MySQL: https://dev.mysql.com/downloads/

### Veritabanı Oluşturma

**MySQL'de (phpMyAdmin veya MySQL Workbench):**

```sql
CREATE DATABASE gmsgarage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**VEYA MySQL komut satırından:**

```bash
mysql -u root -p
```

Sonra:
```sql
CREATE DATABASE gmsgarage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

---

## 🚨 Sorun Giderme

### "composer: command not found"
- Composer'ı yükleyin: https://getcomposer.org/download/
- PATH'e ekleyin

### "php: command not found"
- PHP'yi yükleyin: https://www.php.net/downloads.php
- PATH'e ekleyin

### "npm: command not found"
- Node.js'i yükleyin: https://nodejs.org/
- Node.js ile birlikte NPM gelir

### "Access denied for user 'root'@'localhost'"
- `.env` dosyasında `DB_PASSWORD` değerini kontrol edin
- MySQL şifrenizi doğru yazdığınızdan emin olun

### "SQLSTATE[HY000] [1049] Unknown database 'gmsgarage'"
- Veritabanını oluşturun (yukarıdaki SQL komutunu çalıştırın)

### "Class 'PDO' not found"
- PHP'de PDO extension'ı aktif değil
- `php.ini` dosyasında `extension=pdo_mysql` satırının başındaki `;` işaretini kaldırın

---

## ✅ Başarı Kontrolü

**Her şey tamamlandığında:**

1. ✅ `php artisan serve` komutu çalışıyor
2. ✅ Tarayıcıda http://localhost:8000 açılıyor
3. ✅ Ana sayfa görünüyor
4. ✅ Araçlar listeleniyor
5. ✅ Araç detay sayfaları açılıyor

---

## 🔄 Gelecekte Güncelleme

**Yeni değişiklikleri çekmek için:**

```bash
# Son değişiklikleri çek
git pull

# Yeni bağımlılıklar varsa
composer install
npm install
npm run build

# Yeni migration'lar varsa
php artisan migrate
```

---

## 📝 Özet Komutlar (Kopyala-Yapıştır)

```bash
# 1. Projeyi klonla
cd Desktop
git clone https://github.com/Berjey/gmsgarage.git
cd gmsgarage

# 2. Cursor'da aç
cursor .

# 3. .env oluştur
cp .env.example .env

# 4. .env dosyasını düzenle (Cursor'da açıp DB bilgilerini güncelle)

# 5. Kurulum
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build

# 6. Çalıştır
php artisan serve
```

---

**Son Güncelleme:** 2025-01-15
**Repository:** https://github.com/Berjey/gmsgarage
