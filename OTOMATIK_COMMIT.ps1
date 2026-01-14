# Otomatik Commit ve Push Script
# Kullanım: .\OTOMATIK_COMMIT.ps1 "Commit mesajı"

param(
    [Parameter(Mandatory=$true)]
    [string]$Message
)

Write-Host "🔄 Değişiklikler kontrol ediliyor..." -ForegroundColor Cyan
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
    Write-Host "`n🔗 Repository: https://github.com/Berjey/gmsgarage" -ForegroundColor Cyan
} else {
    Write-Host "`n❌ Push hatası:" -ForegroundColor Red
    Write-Host $pushResult -ForegroundColor Red
    Write-Host "`n💡 Manuel push deneyin: git push" -ForegroundColor Yellow
}
