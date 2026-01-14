#!/bin/bash
# Bash script - Değişiklikleri GitHub'a yüklemek için
# Kullanım: ./git-push.sh "Commit mesajı"

if [ -z "$1" ]; then
    echo "❌ Hata: Commit mesajı gerekli"
    echo "Kullanım: ./git-push.sh 'Commit mesajı'"
    exit 1
fi

echo "🔄 Değişiklikler kontrol ediliyor..."
git status

echo ""
echo "📦 Tüm değişiklikler ekleniyor..."
git add .

echo ""
echo "💾 Commit yapılıyor: $1"
git commit -m "$1"

echo ""
echo "🚀 GitHub'a yükleniyor..."
git push

echo ""
echo "✅ Tamamlandı!"
