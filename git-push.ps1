# PowerShell script - Değişiklikleri GitHub'a yüklemek için
# Kullanım: .\git-push.ps1 "Commit mesajı"

param(
    [Parameter(Mandatory=$true)]
    [string]$Message
)

Write-Host "🔄 Değişiklikler kontrol ediliyor..." -ForegroundColor Cyan
git status

Write-Host "`n📦 Tüm değişiklikler ekleniyor..." -ForegroundColor Cyan
git add .

Write-Host "`n💾 Commit yapılıyor: $Message" -ForegroundColor Cyan
git commit -m $Message

Write-Host "`n🚀 GitHub'a yükleniyor..." -ForegroundColor Cyan
git push

Write-Host "`n✅ Tamamlandı!" -ForegroundColor Green
