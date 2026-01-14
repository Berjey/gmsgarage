# 🔄 Otomatik GitHub Kaydetme Sistemi

## ⚡ Hızlı Kullanım

### Yöntem 1: Manuel Script (Önerilen)

**Cursor'da dosya kaydettikten sonra Terminal'de:**

```powershell
.\OTOMATIK_KAYDET.ps1
```

**VEYA özel mesaj ile:**

```powershell
.\OTOMATIK_KAYDET.ps1 "Ana sayfa tasarımı güncellendi"
```

### Yöntem 2: Cursor Settings (Otomatik)

1. **Cursor Settings'i açın:** `Ctrl+,` (veya `File` → `Preferences` → `Settings`)
2. **Arama kutusuna yazın:** `tasks`
3. **Tasks: Run Task** özelliğini aktif edin
4. **Keyboard Shortcut ekleyin:**
   - `Ctrl+K Ctrl+S` → `Tasks: Run Task` → `OTOMATIK_KAYDET` seçin

### Yöntem 3: Keyboard Shortcut

**Cursor'da `Ctrl+Shift+P` → `Preferences: Open Keyboard Shortcuts`**

Yeni shortcut ekleyin:
- **Command:** `workbench.action.tasks.runTask`
- **Key:** `Ctrl+Alt+S` (veya istediğiniz tuş)
- **Args:** `OTOMATIK_KAYDET`

## 📋 Nasıl Çalışır?

1. ✅ Dosyalarınızı kaydedin (`Ctrl+S`)
2. ✅ Terminal'de `.\OTOMATIK_KAYDET.ps1` çalıştırın
3. ✅ Script otomatik olarak:
   - Değişiklikleri kontrol eder
   - Tüm değişiklikleri ekler (`git add .`)
   - Commit yapar
   - GitHub'a push eder

## 🎯 Örnek Kullanım

```powershell
# Basit kullanım (otomatik mesaj)
.\OTOMATIK_KAYDET.ps1

# Özel mesaj ile
.\OTOMATIK_KAYDET.ps1 "Araç detay sayfası iyileştirildi"

# Özel mesaj ile (tarihli)
.\OTOMATIK_KAYDET.ps1 "Bug fix: Responsive tasarım düzeltmeleri - $(Get-Date -Format 'dd.MM.yyyy')"
```

## ⚙️ Cursor Task Olarak Ekleme

**`.vscode/tasks.json` dosyası oluşturun:**

```json
{
    "version": "2.0.0",
    "tasks": [
        {
            "label": "Otomatik GitHub Kaydet",
            "type": "shell",
            "command": "powershell",
            "args": [
                "-ExecutionPolicy",
                "Bypass",
                "-File",
                "${workspaceFolder}/OTOMATIK_KAYDET.ps1"
            ],
            "problemMatcher": [],
            "presentation": {
                "reveal": "always",
                "panel": "new"
            }
        }
    ]
}
```

**Sonra `Ctrl+Shift+P` → `Tasks: Run Task` → `Otomatik GitHub Kaydet`**

## 🔔 Notlar

- ⚠️ Script sadece değişiklik varsa çalışır
- ⚠️ Eğer push hatası olursa, manuel `git push` deneyin
- ✅ Her commit otomatik olarak GitHub'a yüklenir
- ✅ Commit mesajı otomatik olarak tarih/saat içerir

## 🚨 Sorun Giderme

### "Execution Policy" Hatası

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

### "git: command not found"

Git'in PATH'te olduğundan emin olun.

### Push Hatası

Manuel olarak push edin:
```bash
git push
```

---

**Son Güncelleme:** 2025-01-15
