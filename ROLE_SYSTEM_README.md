# 🔐 ROL BAZLI YETKİLENDİRME SİSTEMİ

## ✅ KURULUM TAMAMLANDI!

GMSGARAGE Admin Paneli artık **Rol Bazlı Yetkilendirme (RBAC)** sistemi ile donatıldı.

---

## 👥 ROLLER VE YETKİLER

### 🔴 Süper Yönetici (admin)
**Tüm Yetkiler**
- ✅ Dashboard
- ✅ Araçlar (Ekleme, Düzenleme, Silme)
- ✅ Blog (Ekleme, Düzenleme, Silme)
- ✅ Sayfalar (Ekleme, Düzenleme, Silme)
- ✅ Medya Yönetimi
- ✅ İletişim Mesajları
- ✅ Araç İstekleri
- ✅ Değerleme İstekleri
- ✅ Sitemap Yönetimi
- ✅ **Site Ayarları** (Sadece Admin)
- ✅ **Kullanıcı Yönetimi** (Sadece Admin)

### 🔵 Galeri Yöneticisi (manager)
**Araç ve Mesaj Yönetimi**
- ✅ Dashboard
- ✅ Araçlar (Ekleme, Düzenleme, Silme)
- ✅ Blog (Ekleme, Düzenleme, Silme)
- ✅ Medya Yönetimi
- ✅ İletişim Mesajları
- ✅ Araç İstekleri
- ✅ Değerleme İstekleri
- ❌ Sayfalar
- ❌ Sitemap
- ❌ Site Ayarları
- ❌ Kullanıcı Yönetimi

### 🟢 İçerik Editörü (editor)
**Sadece Blog Yönetimi**
- ✅ Dashboard
- ✅ Blog (Ekleme, Düzenleme, Silme)
- ❌ Araçlar
- ❌ Sayfalar
- ❌ Medya
- ❌ Mesajlar
- ❌ Site Ayarları
- ❌ Kullanıcı Yönetimi

---

## 🔑 DEMO KULLANICILAR

Sistem 3 demo kullanıcı ile gelir:

```
📧 Süper Yönetici
Email: admin@gmsgarage.com
Şifre: admin123

📧 Galeri Yöneticisi
Email: manager@gmsgarage.com
Şifre: manager123

📧 İçerik Editörü
Email: editor@gmsgarage.com
Şifre: editor123
```

---

## 🛠️ YAPILAN DEĞİŞİKLİKLER

### 1. ✅ Veritabanı
- `users` tablosuna `role` sütunu eklendi (enum: admin, manager, editor)
- Migration çalıştırıldı

### 2. ✅ User Model
- Helper metodlar eklendi:
  - `isAdmin()` - Admin kontrolü
  - `isManager()` - Manager kontrolü
  - `isEditor()` - Editor kontrolü
  - `hasRole($role)` - Belirli rol kontrolü
  - `hasAnyRole($roles)` - Birden fazla rol kontrolü
  - `role_name` - Türkçe rol ismi (accessor)
  - `role_badge_color` - Badge rengi (accessor)

### 3. ✅ Middleware
- `CheckRole` middleware oluşturuldu
- `app/Http/Kernel.php` içine `role` alias'ı eklendi

### 4. ✅ Routes (admin.php)
- Rotalar 3 gruba ayrıldı:
  - **Sadece Admin**: Settings, Users, Pages, Sitemap
  - **Admin + Manager**: Vehicles, Messages, Requests, Media
  - **Herkes**: Blog

### 5. ✅ Views
- **Kullanıcı Listesi**: Renkli role badge'leri eklendi
- **Kullanıcı Ekleme/Düzenleme**: Role seçim dropdown'u eklendi
- **Sidebar**: Role göre menü filtreleme
- **User Profile**: Sidebar'da role badge gösterimi

### 6. ✅ 403 Hata Sayfası
- Özel yetkisiz erişim sayfası oluşturuldu
- Kullanıcının mevcut rolü gösteriliyor

### 7. ✅ Seeder
- Demo kullanıcılar için seeder oluşturuldu
- Mevcut kullanıcılar otomatik 'admin' rolüne atandı

---

## 🧪 TEST SENARYOLARI

### Test 1: Admin Kullanıcısı
1. `admin@gmsgarage.com` ile giriş yap
2. Tüm menüleri görebilmelisin
3. Settings ve Users sayfalarına erişebilmelisin

### Test 2: Manager Kullanıcısı
1. `manager@gmsgarage.com` ile giriş yap
2. Araçlar, Blog, Mesajlar menülerini görebilmelisin
3. Settings ve Users menülerini GÖREMEMELİSİN
4. `/admin/settings` linkine gitmeyi dene → **403 Hatası almalısın**

### Test 3: Editor Kullanıcısı
1. `editor@gmsgarage.com` ile giriş yap
2. Sadece Blog menüsünü görebilmelisin
3. Araçlar, Settings, Users menülerini GÖREMEMELİSİN
4. `/admin/vehicles` linkine gitmeyi dene → **403 Hatası almalısın**

---

## 📝 YENİ KULLANICI EKLEME

1. Admin hesabıyla giriş yap
2. **Kullanıcılar** menüsüne git
3. **Yeni Kullanıcı** butonuna tıkla
4. Formu doldur:
   - Ad Soyad
   - E-posta
   - Şifre (min 8 karakter)
   - **Rol Seçimi** (Dropdown'dan seç)
5. Kaydet

---

## 🔒 GÜVENLİK

### Frontend Güvenlik (Blade)
```blade
@if(auth()->user()->hasRole('admin'))
    <!-- Sadece admin görebilir -->
@endif

@if(auth()->user()->hasAnyRole(['admin', 'manager']))
    <!-- Admin ve Manager görebilir -->
@endif
```

### Backend Güvenlik (Routes)
```php
Route::middleware(['role:admin'])->group(function () {
    // Sadece admin erişebilir
});

Route::middleware(['role:admin,manager'])->group(function () {
    // Admin ve Manager erişebilir
});
```

### Controller Güvenlik (Opsiyonel)
```php
if (!auth()->user()->hasRole('admin')) {
    abort(403, 'Bu işlem için yetkiniz yok.');
}
```

---

## 🎨 BADGE RENKLERİ

- 🔴 **Admin**: Kırmızı (`bg-red-100 text-red-800`)
- 🔵 **Manager**: Mavi (`bg-blue-100 text-blue-800`)
- 🟢 **Editor**: Yeşil (`bg-green-100 text-green-800`)

---

## 📂 DOSYA YAPISI

```
app/
├── Http/
│   ├── Controllers/Admin/
│   │   └── UserController.php (✅ Güncellendi)
│   ├── Middleware/
│   │   └── CheckRole.php (🆕 Yeni)
│   └── Kernel.php (✅ Güncellendi)
├── Models/
│   └── User.php (✅ Güncellendi)

database/
├── migrations/
│   └── 2026_02_16_*_add_role_to_users_table.php (🆕 Yeni)
└── seeders/
    └── RoleUsersSeeder.php (🆕 Yeni)

resources/views/
├── admin/
│   ├── layouts/
│   │   └── sidebar.blade.php (✅ Güncellendi)
│   └── users/
│       ├── index.blade.php (✅ Güncellendi)
│       ├── create.blade.php (✅ Güncellendi)
│       └── edit.blade.php (✅ Güncellendi)
└── errors/
    └── 403.blade.php (🆕 Yeni)

routes/
└── admin.php (✅ Güncellendi - Role grupları eklendi)
```

---

## 🚀 SONRAKI ADIMLAR (Opsiyonel)

1. **Activity Log**: Kullanıcı hareketlerini kaydet
2. **Permission System**: Daha detaylı yetki sistemi (örn: "blog.create", "blog.edit")
3. **Role Management UI**: Rolleri admin panelinden düzenle
4. **Email Notifications**: Yeni kullanıcı oluşturulduğunda email gönder

---

## ❓ SORUN GİDERME

### Sidebar'da menüler görünmüyor
```bash
php artisan view:clear
php artisan cache:clear
```

### 403 hatası alıyorum ama yetkim var
```bash
php artisan route:clear
php artisan config:clear
```

### Kullanıcı rolü null
```bash
php artisan db:seed --class=RoleUsersSeeder
```

---

## 📞 DESTEK

Herhangi bir sorun yaşarsanız:
- Loglara bakın: `storage/logs/laravel.log`
- Cache'leri temizleyin: `php artisan optimize:clear`

---

**✅ SİSTEM HAZIR!**

Artık güvenli ve ölçeklenebilir bir rol sisteminiz var! 🎉
