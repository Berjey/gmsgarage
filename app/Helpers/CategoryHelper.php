<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class CategoryHelper
{
    /**
     * Kategori görseli URL'ini getir
     */
    public static function getCategoryImage($categoryName)
    {
        if (empty($categoryName)) {
            return null;
        }

        $slug = \Illuminate\Support\Str::slug($categoryName);
        $imagePath = "blog/categories/category_{$slug}_*.jpg";
        
        // Storage'da kategori görseli var mı kontrol et
        $files = Storage::disk('public')->files('blog/categories');
        foreach ($files as $file) {
            if (str_contains($file, "category_{$slug}_")) {
                return asset('storage/' . $file);
            }
        }

        return null;
    }

    /**
     * Kategori görseli var mı kontrol et
     */
    public static function hasCategoryImage($categoryName)
    {
        return self::getCategoryImage($categoryName) !== null;
    }
}
