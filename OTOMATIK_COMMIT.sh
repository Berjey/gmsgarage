#!/bin/bash
# Otomatik Commit ve Push Script (Linux/Mac)
# Kullanım: ./OTOMATIK_COMMIT.sh "Commit mesajı"

if [ -z "$1" ]; then
    echo "❌ Hata: Commit mesajı gerekli"
    echo "Kullanım: ./OTOMATIK_COMMIT.sh 'Commit mesajı'"
    exit 1
fi

echo "🔄 Değişiklikler kontrol ediliyor..."
STATUS=$(git status --short)

if [ -z "$STATUS" ]; then
    echo "ℹ️  Yeni değişiklik yok."
    exit 0
fi

echo ""
echo "📦 Değişiklikler:"
git status --short

echo ""
echo "📦 Tüm değişiklikler ekleniyor..."
git add .

echo ""
echo "💾 Commit yapılıyor: $1"
git commit -m "$1"

echo ""
echo "🚀 GitHub'a yükleniyor..."
if git push; then
    echo ""
    echo "✅ Başarıyla GitHub'a yüklendi!"
    echo ""
    echo "🔗 Repository: https://github.com/Berjey/gmsgarage"
else
    echo ""
    echo "❌ Push hatası!"
    echo "💡 Manuel push deneyin: git push"
    exit 1
fi
