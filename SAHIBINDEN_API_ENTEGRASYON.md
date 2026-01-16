# Sahibinden.com API Entegrasyon Rehberi

## 📋 Genel Bakış

Bu proje, Sahibinden.com API'si ile entegrasyon için hazırlanmıştır. API bilgileri geldiğinde kolayca bağlantı kurulabilir.

## 🔧 Kurulum

### 1. .env Dosyasına API Bilgilerini Ekleyin

`.env` dosyanıza aşağıdaki satırları ekleyin:

```env
SAHIBINDEN_API_URL=https://api.sahibinden.com/v1
SAHIBINDEN_API_KEY=your_api_key_here
SAHIBINDEN_API_SECRET=your_api_secret_here
```

**Not:** API bilgileri Sahibinden.com hesabınızdan alınacaktır.

### 2. Config Cache Temizleme

```bash
php artisan config:clear
```

## 📁 Oluşturulan Dosyalar

### 1. `app/Services/SahibindenApiService.php`
- API ile iletişim kurmak için servis sınıfı
- `testConnection()`: API bağlantısını test eder
- `getVehicles()`: Filtrelenmiş araç listesi getirir
- `getVehicleDetail()`: Tek bir aracın detayını getirir
- `isConfigured()`: API bilgilerinin yapılandırılmış olup olmadığını kontrol eder

### 2. `app/Console/Commands/SyncSahibindenVehicles.php`
- Artisan komutu: `php artisan sahibinden:sync`
- API'den araçları çeker ve veritabanına kaydeder
- Mevcut araçları günceller, yeni araçları ekler

### 3. `config/services.php`
- API yapılandırma dosyası güncellendi
- `.env` dosyasından API bilgilerini okur

## 🚀 Kullanım

### API Servisini Kullanma

```php
use App\Services\SahibindenApiService;

$apiService = new SahibindenApiService();

// API bağlantısını test et
if ($apiService->testConnection()) {
    echo "API bağlantısı başarılı!";
}

// Araçları getir
$filters = [
    'brand' => 'Audi',
    'min_price' => 500000,
    'max_price' => 2000000
];
$vehicles = $apiService->getVehicles($filters);
```

### Artisan Komutu ile Senkronizasyon

```bash
# Tüm araçları senkronize et
php artisan sahibinden:sync

# Belirli sayıda araç senkronize et
php artisan sahibinden:sync --limit=100
```

### VehicleController'da Kullanım

`VehicleController` içinde API servisini kullanarak araçları getirebilirsiniz:

```php
use App\Services\SahibindenApiService;

public function index(Request $request)
{
    $apiService = new SahibindenApiService();
    
    if ($apiService->isConfigured()) {
        // API'den araçları getir
        $filters = $request->only(['brand', 'fuel_type', 'min_price', 'max_price', 'body_type']);
        $vehicles = $apiService->getVehicles($filters);
        
        // API'den gelen verileri işle ve göster
        // ...
    } else {
        // Veritabanından araçları getir (mevcut sistem)
        // ...
    }
}
```

## 📊 Veritabanı Yapısı

`vehicles` tablosunda aşağıdaki alanlar Sahibinden API için hazırdır:

- `sahibinden_id`: Sahibinden.com'daki araç ID'si
- `sahibinden_url`: Sahibinden.com'daki araç URL'si

## ⚙️ API Endpoint'leri (Örnek)

API dokümantasyonuna göre endpoint'ler güncellenecektir:

- `GET /vehicles` - Araç listesi (filtrelerle)
- `GET /vehicles/{id}` - Araç detayı
- `POST /vehicles` - Yeni araç ekleme (opsiyonel)
- `PUT /vehicles/{id}` - Araç güncelleme (opsiyonel)

## 🔒 Güvenlik

- API Key ve Secret `.env` dosyasında saklanmalıdır
- `.env` dosyası `.gitignore` içinde olmalıdır
- Production'da API bilgileri güvenli şekilde saklanmalıdır

## 📝 Notlar

1. **Cache**: API yanıtları 5 dakika cache'lenir (performans için)
2. **Error Handling**: Tüm API hataları loglanır (`storage/logs/laravel.log`)
3. **Timeout**: API istekleri 30 saniye timeout'a sahiptir
4. **Rate Limiting**: API rate limit'leri varsa, servis içinde eklenmelidir

## 🐛 Sorun Giderme

### API Bağlantı Hatası

```bash
# Log dosyasını kontrol edin
tail -f storage/logs/laravel.log

# API bilgilerini kontrol edin
php artisan tinker
>>> config('services.sahibinden')
```

### Cache Sorunları

```bash
php artisan cache:clear
php artisan config:clear
```

## 📞 Destek

API bilgileri geldiğinde:
1. `.env` dosyasına API bilgilerini ekleyin
2. `SahibindenApiService.php` içindeki endpoint'leri API dokümantasyonuna göre güncelleyin
3. `SyncSahibindenVehicles.php` komutundaki veri mapping'ini API response formatına göre ayarlayın

## ✅ Hazırlık Durumu

- ✅ API Servis sınıfı oluşturuldu
- ✅ Artisan komutu hazırlandı
- ✅ Config dosyası güncellendi
- ✅ Vehicle model'inde sahibinden_id ve sahibinden_url alanları mevcut
- ⏳ API bilgileri bekleniyor (.env dosyasına eklenecek)
- ⏳ API endpoint'leri API dokümantasyonuna göre güncellenecek
