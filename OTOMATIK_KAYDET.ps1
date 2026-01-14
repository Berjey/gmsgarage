# Otomatik Kaydet ve GitHub'a Push Script
# Cursor'da dosya kaydedildiğinde bu script'i çalıştırın
# Veya Cursor Settings'te "onSave" event'ine ekleyin

param(
    [string]$Message = "Otomatik kayıt: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
)

Write-Host "`n🔄 Otomatik kayıt başlatılıyor..." -ForegroundColor Cyan

# Git durumunu kontrol et
$status = git status --short

if ([string]::IsNullOrWhiteSpace($status)) {
    Write-Host "ℹ️  Yeni değişiklik yok." -ForegroundColor Yellow
    exit 0
}

Write-Host "`n📦 Değişiklikler:" -ForegroundColor Cyan
git status --short

Write-Host "`n📦 Tüm değişiklikler ekleniyor..." -ForegroundColor Cyan
git add .

Write-Host "`n💾 Commit yapılıyor: $Message" -ForegroundColor Cyan
git commit -m $Message

Write-Host "`n🚀 GitHub'a yükleniyor..." -ForegroundColor Cyan
$pushResult = git push 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host "`n✅ Başarıyla GitHub'a yüklendi!" -ForegroundColor Green
    Write-Host "🔗 Repository: https://github.com/Berjey/gmsgarage" -ForegroundColor Cyan
} else {
    Write-Host "`n❌ Push hatası:" -ForegroundColor Red
    Write-Host $pushResult -ForegroundColor Red
    Write-Host "`n💡 Manuel push deneyin: git push" -ForegroundColor Yellow
}
