# Otomatik Kaydet ve GitHub'a Push Script
# Cursor'da dosya kaydedildiğinde bu script'i çalıştırın

param(
    [string]$Message = "Otomatik kayit: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
)

Write-Host ""
Write-Host "Otomatik kayit baslatiliyor..." -ForegroundColor Cyan

# Git durumunu kontrol et
$status = git status --short

if ([string]::IsNullOrWhiteSpace($status)) {
    Write-Host "Yeni degisiklik yok." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "Degisiklikler:" -ForegroundColor Cyan
git status --short

Write-Host ""
Write-Host "Tum degisiklikler ekleniyor..." -ForegroundColor Cyan
git add .

Write-Host ""
Write-Host "Commit yapiliyor: $Message" -ForegroundColor Cyan
git commit -m $Message

Write-Host ""
Write-Host "GitHub'a yukleniyor..." -ForegroundColor Cyan
$pushResult = git push 2>&1

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "Basarili! GitHub'a yuklendi!" -ForegroundColor Green
    Write-Host "Repository: https://github.com/Berjey/gmsgarage" -ForegroundColor Cyan
} else {
    Write-Host ""
    Write-Host "Push hatasi:" -ForegroundColor Red
    Write-Host $pushResult -ForegroundColor Red
    Write-Host ""
    Write-Host "Manuel push deneyin: git push" -ForegroundColor Yellow
}
