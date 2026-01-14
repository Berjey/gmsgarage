# GMSGARAGE - Kurulum Rehberi

## Gereksinimler

- PHP 8.1 veya üzeri
- Composer
- MySQL 5.7 veya üzeri
- Node.js 16+ ve NPM

## Adım Adım Kurulum

### 1. Composer Bağımlılıklarını Yükle

```bash
composer install
```

### 2. Ortam Dosyasını Oluştur

```bash
cp .env.example .env
```

Veya manuel olarak `.env` dosyası oluşturun ve aşağıdaki içeriği ekleyin:

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

### 3. Uygulama Anahtarını Oluştur

```bash
php artisan key:generate
```

### 4. Veritabanını Oluştur

MySQL'de yeni bir veritabanı oluşturun:

```sql
CREATE DATABASE gmsgarage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Migration'ları Çalıştır

```bash
php artisan migrate
```

### 6. Seed Verilerini Yükle

```bash
php artisan db:seed
```

Bu komut 6 adet dummy araç verisi oluşturacaktır.

### 7. Storage Link Oluştur

```bash
php artisan storage:link
```

### 8. NPM Bağımlılıklarını Yükle

```bash
npm install
```

### 9. Frontend Assets'i Build Et

Production için:
```bash
npm run build
```

Development için (hot reload):
```bash
npm run dev
```

### 10. Sunucuyu Başlat

```bash
php artisan serve
```

Tarayıcıda `http://localhost:8000` adresine gidin.

## Logo Ekleme

Logo dosyasını `public/images/logo.png` konumuna yerleştirin. Eğer logo yoksa, header'da "GMSGARAGE" yazısı görünecektir.

## Araç Görselleri

Dummy araç görsellerini `public/images/vehicles/` klasörüne ekleyebilirsiniz. Seed dosyasında belirtilen görsel yolları:

- `/images/vehicles/bmw-320i-1.jpg`
- `/images/vehicles/mercedes-c200-1.jpg`
- `/images/vehicles/audi-a4-1.jpg`
- vb.

Eğer görseller yoksa, varsayılan placeholder görsel gösterilecektir.

## Sorun Giderme

### Composer Hatası
Eğer `composer` komutu bulunamıyorsa:
- Composer'ı [getcomposer.org](https://getcomposer.org/) adresinden indirip kurun
- Veya global olarak yükleyin: `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`

### Veritabanı Bağlantı Hatası
- `.env` dosyasındaki veritabanı bilgilerini kontrol edin
- MySQL servisinin çalıştığından emin olun
- Veritabanının oluşturulduğundan emin olun

### Asset Build Hatası
- Node.js ve NPM'in yüklü olduğundan emin olun
- `npm install` komutunu tekrar çalıştırın
- `node_modules` klasörünü silip tekrar `npm install` yapın

## Hostinger Deploy

1. `.env` dosyasını production ayarlarıyla güncelleyin:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

2. `public` klasörünün içeriğini `public_html` klasörüne yükleyin
3. Diğer dosyaları bir üst dizine yükleyin
4. `storage` ve `bootstrap/cache` klasörlerine yazma izni verin (755 veya 775)
5. `php artisan config:cache` ve `php artisan route:cache` komutlarını çalıştırın

## Notlar

- Bu fazda admin panel yok
- Sahibinden API entegrasyonu altyapı hazır, gerçek entegrasyon Faz 2'de yapılacak
- Tüm araç verileri veritabanından geliyor (hardcode değil)
- Slug yapısı: `/araclar/{slug}` formatında çalışıyor
