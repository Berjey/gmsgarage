<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SahibindenImporterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SahibindenImportController extends Controller
{
    public function __construct(private SahibindenImporterService $importer) {}

    /**
     * Sahibinden.com ilanını çeker, ayrıştırır ve form populate için JSON döner.
     */
    public function import(Request $request): JsonResponse
    {
        $request->validate(
            ['url' => 'required|url|max:600'],
            [
                'url.required' => 'URL zorunludur.',
                'url.url'      => 'Geçerli bir URL girin.',
                'url.max'      => 'URL çok uzun.',
            ]
        );

        $url = trim($request->input('url'));

        try {
            $result = $this->importer->import($url);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 502);
        } catch (\Throwable $e) {
            // İçsel hata — kullanıcıya genel mesaj, log'a detay
            Log::error('Sahibinden import beklenmeyen hata', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyin.',
            ], 500);
        }

        // Görüntüleme için resolved URL'lere çevir (storage symlink)
        $resolvedImages = array_map(
            fn ($path) => \App\Models\Vehicle::resolveImageUrl($path),
            $result['data']['images'] ?? []
        );

        return response()->json([
            'success'           => true,
            'data'              => $result['data'],
            'resolved_images'   => $resolvedImages,
            'images_downloaded' => $result['images_downloaded'],
            'warnings'          => $result['warnings'],
            'duplicate'         => $result['duplicate'],
            'catalog_match'     => $result['catalog_match'],
        ]);
    }
}
