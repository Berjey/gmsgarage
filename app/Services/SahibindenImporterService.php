<?php

namespace App\Services;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Sahibinden.com araç ilanı içe aktarma servisi — Faz 1 (Sertleştirilmiş)
 *
 * Strateji:
 *  1. JSON-LD (<script type="application/ld+json">) — en güvenilir
 *  2. window.classified / gömülü JSON
 *  3. DOMDocument HTML ayrıştırma — fallback
 *
 * Görsel: geçici olarak 'vehicles/tmp_import/' klasörüne indirilir.
 * İndirilecek max görsel: MAX_IMAGES.
 * Admin formu kaydettiğinde görseller kalıcı yola taşınır,
 * taşınmayan (orphan) görseller bir sonraki import başlangıcında temizlenir.
 */
class SahibindenImporterService
{
    private const USER_AGENT        = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36';
    private const MAX_IMAGES        = 3;
    private const MAX_IMAGE_TIMEOUT = 6;
    private const FETCH_TIMEOUT     = 22;
    private const MAX_IMAGE_BYTES   = 8 * 1024 * 1024; // 8 MB
    private const MAX_HTML_BYTES    = 6 * 1024 * 1024; // 6 MB
    private const TMP_PREFIX        = 'tmp_sahibinden_';
    public  const SESSION_KEY       = 'sahibinden_import_pending_images';

    // Sahibinden specs label → Vehicle alan adı eşleştirmesi
    private const SPEC_MAP = [
        'Marka'              => 'brand',
        'Seri'               => 'model',
        'Model'              => 'package_version',
        'Yıl'                => 'year',
        'KM'                 => 'kilometer',
        'Yakıt Tipi'         => 'fuel_type',
        'Vites Tipi'         => 'transmission',
        'Kasa Tipi'          => 'body_type',
        'Renk'               => 'color',
        'Motor Hacmi'        => 'engine_size',
        'Beygir Gücü'        => 'horse_power',
        'Çekiş'              => 'drive_type',
        'Kapı Sayısı'        => 'door_count',
        'Oturma Kapasitesi'  => 'seat_count',
    ];

    // ─────────────────────────────────────────────────────────────────────────
    // Public API
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Ana import metodu.
     *
     * @return array{
     *   data: array,
     *   warnings: string[],
     *   images_downloaded: int,
     *   duplicate: array|null,
     *   catalog_match: array
     * }
     */
    public function import(string $url): array
    {
        $url = $this->normalizeUrl($url);
        $this->validateUrl($url);

        // Önceki oturumdaki orphan görselleri temizle
        $this->cleanupOrphanImages();

        $sahibindenId = $this->extractId($url);

        // Güçlendirilmiş duplicate kontrolü (id + url)
        $duplicate = $this->checkDuplicate($sahibindenId, $url);

        $html   = $this->fetchHtml($url);
        $parsed = $this->parseAll($html, $url, $sahibindenId);

        // İçsel _warnings ve _raw_image_urls data'dan ayır
        $warnings     = $parsed['_warnings']      ?? [];
        $rawImageUrls = $parsed['_raw_image_urls'] ?? [];
        unset($parsed['_warnings'], $parsed['_raw_image_urls']);

        // Catalog eşleştirme (brand/model)
        $catalogMatch = $this->matchCatalog($parsed['brand'] ?? null, $parsed['model'] ?? null);

        // Görselleri geçici olarak indir
        $downloadedImages = $this->downloadImages($rawImageUrls);

        // Session'a kaydet (orphan temizliği için)
        session()->put(self::SESSION_KEY, $downloadedImages);

        // images dizisi + images_meta oluştur
        $parsed['images']      = $downloadedImages;
        $parsed['image']       = $downloadedImages[0] ?? null;
        $parsed['images_meta'] = \App\Models\Vehicle::buildImagesMeta(
            $downloadedImages,
            $downloadedImages[0] ?? null
        );

        return [
            'data'              => $parsed,
            'warnings'          => $warnings,
            'images_downloaded' => count($downloadedImages),
            'duplicate'         => $duplicate,
            'catalog_match'     => $catalogMatch,
        ];
    }

    /**
     * Araç başarıyla kaydedildiğinde çağrılır — session temiz kalır.
     */
    public function confirmSave(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // URL doğrulama + normalizasyon
    // ─────────────────────────────────────────────────────────────────────────

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);

        // Tracking parametrelerini kaldır (?query=...) — sadece temel URL kalsın
        $parsed = parse_url($url);
        if (!$parsed) return $url;

        $clean  = ($parsed['scheme'] ?? 'https') . '://';
        $clean .= $parsed['host'] ?? '';
        $clean .= $parsed['path'] ?? '';

        return rtrim($clean, '/');
    }

    private function validateUrl(string $url): void
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Geçersiz URL formatı. Tam bir sahibinden.com linki girin.');
        }
        $host = parse_url($url, PHP_URL_HOST) ?? '';
        if (!str_ends_with($host, 'sahibinden.com')) {
            throw new \InvalidArgumentException('Lütfen geçerli bir sahibinden.com linki girin.');
        }
    }

    private function extractId(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        // /ilan/.../1234567890 formatı (7+ basamak)
        if (preg_match('/\/(\d{7,})\/?$/', $path, $m)) {
            return $m[1];
        }
        // Segment içinde 8+ basamak
        if (preg_match('/\/(\d{8,})/', $path, $m)) {
            return $m[1];
        }
        return null;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Duplicate kontrolü — id VE url
    // ─────────────────────────────────────────────────────────────────────────

    private function checkDuplicate(?string $sahibindenId, string $url): ?array
    {
        $existing = null;

        if ($sahibindenId) {
            $existing = \App\Models\Vehicle::where('sahibinden_id', $sahibindenId)->first();
        }

        // ID eşleşmedi ise URL ile kontrol et
        if (!$existing) {
            $existing = \App\Models\Vehicle::where('sahibinden_url', 'LIKE', '%' . parse_url($url, PHP_URL_PATH) . '%')->first();
        }

        if (!$existing) return null;

        return [
            'id'    => $existing->id,
            'title' => $existing->title,
            'url'   => route('admin.vehicles.edit', $existing->id),
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // HTTP fetch
    // ─────────────────────────────────────────────────────────────────────────

    private function fetchHtml(string $url): string
    {
        $cookiePath = tempnam(sys_get_temp_dir(), 'sahibinden_');

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 4,
            CURLOPT_TIMEOUT        => self::FETCH_TIMEOUT,
            CURLOPT_USERAGENT      => self::USER_AGENT,
            CURLOPT_ENCODING       => '',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_BUFFERSIZE     => 131072,
            CURLOPT_COOKIEJAR      => $cookiePath,
            CURLOPT_COOKIEFILE     => $cookiePath,
            CURLOPT_HTTPHEADER     => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8',
                'Cache-Control: no-cache',
                'Pragma: no-cache',
                'Upgrade-Insecure-Requests: 1',
                'Referer: https://www.sahibinden.com/',
                'Sec-Fetch-Dest: document',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-Site: same-origin',
            ],
        ]);

        $html       = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError  = curl_error($ch);
        curl_close($ch);

        // Cookie dosyasını temizle
        if (file_exists($cookiePath)) @unlink($cookiePath);

        if ($curlError) {
            if (str_contains($curlError, 'Operation timed out') || str_contains($curlError, 'timed out')) {
                throw new \RuntimeException('Sayfa zaman aşımına uğradı. İnternet bağlantısını veya URL\'yi kontrol edin.');
            }
            throw new \RuntimeException('Sayfa yüklenemedi: bağlantı hatası.');
        }

        match (true) {
            $statusCode === 403 => throw new \RuntimeException('Sahibinden.com bu isteği engelledi (403). Birkaç dakika bekleyip tekrar deneyin.'),
            $statusCode === 429 => throw new \RuntimeException('Çok fazla istek gönderildi (429). Birkaç dakika bekleyip tekrar deneyin.'),
            $statusCode === 404 => throw new \RuntimeException('İlan bulunamadı (404). URL\'yi kontrol edin.'),
            $statusCode === 410 => throw new \RuntimeException('İlan kaldırılmış veya silinmiş (410).'),
            $statusCode !== 200 => throw new \RuntimeException("Sayfa erişilemez (HTTP {$statusCode}). URL'yi kontrol edin."),
            default             => null,
        };

        if (empty($html) || strlen($html) < 300) {
            throw new \RuntimeException('Sayfa içeriği çok kısa döndü. Bot koruması aktif olabilir.');
        }

        // Hafıza koruması: aşırı büyük HTML'i kes
        if (strlen($html) > self::MAX_HTML_BYTES) {
            $html = substr($html, 0, self::MAX_HTML_BYTES);
        }

        return $html;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Parsing — 3 katmanlı strateji
    // ─────────────────────────────────────────────────────────────────────────

    private function parseAll(string $html, string $url, ?string $id): array
    {
        $warnings = [];
        $data     = [
            'sahibinden_url' => $url,
            'sahibinden_id'  => $id,
            'source'         => 'sahibinden',
        ];

        // Strateji 1: JSON-LD
        $jsonLd = $this->extractJsonLd($html);
        if ($jsonLd) {
            $data = array_merge($data, $this->mapJsonLd($jsonLd));
        }

        // Strateji 2: Gömülü window veri nesnesi
        $windowData = $this->extractWindowData($html);
        if ($windowData) {
            $this->mergeIfMissing($data, $this->mapWindowData($windowData));
        }

        // Strateji 3: DOM ayrıştırma
        $dom   = $this->buildDom($html);
        $xpath = new \DOMXPath($dom);

        foreach ($this->domExtractors() as $field => $extractor) {
            if (empty($data[$field])) {
                $value = $extractor($xpath, $html);
                if ($value !== null && $value !== '') {
                    $data[$field] = $value;
                }
            }
        }

        // Görsel URL'leri (her zaman DOM + JSON-LD birleşik)
        $data['_raw_image_urls'] = $this->extractImageUrls($xpath, $html, $jsonLd);

        // Sayısal normalizasyon
        $data = $this->normalizeNumericFields($data);

        // Enum normalizasyon
        $data = $this->normalizeFieldValues($data);

        // Metin güvenlik limitleri
        $data = $this->applyTextLimits($data);

        // Minimum alan kontrolü
        if (empty($data['title']) && empty($data['brand'])) {
            $warnings[] = 'Araç başlığı ve marka bilgisi çekilemedi. Sayfa yapısı değişmiş olabilir.';
        }
        if (empty($data['price'])) {
            $warnings[] = 'Fiyat bilgisi çekilemedi.';
        }

        $data['_warnings'] = $warnings;

        // null, '' ve false değerleri temizle — _warnings ve _raw_image_urls koruma altında
        $warnings_backup   = $data['_warnings'];
        $raw_img_backup    = $data['_raw_image_urls'];
        $data = array_filter($data, fn ($v) => $v !== null && $v !== '' && $v !== false);
        $data['_warnings']      = $warnings_backup;
        $data['_raw_image_urls'] = $raw_img_backup;

        return $data;
    }

    /** Sadece boş alanları doldur, var olanları koruma */
    private function mergeIfMissing(array &$data, array $incoming): void
    {
        foreach ($incoming as $key => $value) {
            if (empty($data[$key]) && !empty($value)) {
                $data[$key] = $value;
            }
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Strateji 1 — JSON-LD
    // ─────────────────────────────────────────────────────────────────────────

    private function extractJsonLd(string $html): ?array
    {
        if (!preg_match_all('/<script[^>]+type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/si', $html, $matches)) {
            return null;
        }
        foreach ($matches[1] as $json) {
            $decoded = json_decode(trim($json), true);
            if (!$decoded) continue;

            $objects = isset($decoded[0]) ? $decoded : [$decoded];
            foreach ($objects as $obj) {
                $type = $obj['@type'] ?? '';
                if (in_array($type, ['Product', 'Vehicle', 'Car', 'ItemPage'], true)) {
                    return $obj;
                }
            }
        }
        return null;
    }

    private function mapJsonLd(array $ld): array
    {
        $data = [];

        if (!empty($ld['name']))        $data['title']       = $this->cleanText($ld['name']);
        if (!empty($ld['description'])) $data['description'] = $this->cleanText($ld['description']);

        $offers = $ld['offers'] ?? $ld['offer'] ?? null;
        if ($offers) {
            $price = $offers['price'] ?? $offers['lowPrice'] ?? null;
            if ($price !== null) {
                $parsed = $this->parsePrice((string) $price);
                if ($parsed > 0) $data['price'] = $parsed;
            }
        }

        if (!empty($ld['brand']['name']))       $data['brand']        = $this->cleanText($ld['brand']['name']);
        if (!empty($ld['vehicleModelDate']))     $data['year']         = (int) $ld['vehicleModelDate'];
        if (!empty($ld['mileageFromOdometer'])) {
            $km = $this->parseKm($ld['mileageFromOdometer']['value'] ?? $ld['mileageFromOdometer']);
            if ($km > 0) $data['kilometer'] = $km;
        }
        if (!empty($ld['fuelType']))            $data['fuel_type']    = $this->cleanText($ld['fuelType']);
        if (!empty($ld['vehicleTransmission'])) $data['transmission'] = $this->cleanText($ld['vehicleTransmission']);
        if (!empty($ld['bodyType']))            $data['body_type']    = $this->cleanText($ld['bodyType']);
        if (!empty($ld['color']))               $data['color']        = $this->cleanText($ld['color']);

        $images = $ld['image'] ?? [];
        if (is_string($images)) $images = [$images];
        if (!empty($images)) {
            $data['_jsonld_images'] = array_slice(
                array_filter($images, fn ($u) => is_string($u) && filter_var($u, FILTER_VALIDATE_URL)),
                0,
                self::MAX_IMAGES * 2
            );
        }

        return $data;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Strateji 2 — window.classified
    // ─────────────────────────────────────────────────────────────────────────

    private function extractWindowData(string $html): ?array
    {
        $patterns = [
            '/window\.classified\s*=\s*(\{.+?\})\s*;/s',
            '/window\.__PRELOADED_STATE__\s*=\s*(\{.+?\})\s*;/s',
            '/window\.__DATA__\s*=\s*(\{.+?\})\s*;/s',
        ];
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $html, $m)) {
                $decoded = json_decode($m[1], true);
                if ($decoded) return $decoded;
            }
        }
        return null;
    }

    private function mapWindowData(array $data): array
    {
        $mapped = [];
        $info   = $data['classifiedDetail'] ?? $data['detail'] ?? $data;

        if (!empty($info['title']))        $mapped['title']       = $this->cleanText((string) $info['title']);
        if (!empty($info['description']))  $mapped['description'] = $this->cleanText((string) $info['description']);

        $rawPrice = $info['price']['value'] ?? $info['price'] ?? null;
        if ($rawPrice !== null) {
            $p = $this->parsePrice((string) $rawPrice);
            if ($p > 0) $mapped['price'] = $p;
        }

        $brand = $info['brand']['name'] ?? $info['brand'] ?? null;
        if ($brand) $mapped['brand'] = $this->cleanText((string) $brand);

        return $mapped;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Strateji 3 — DOM ayrıştırma
    // ─────────────────────────────────────────────────────────────────────────

    private function buildDom(string $html): \DOMDocument
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        return $dom;
    }

    private function domExtractors(): array
    {
        return [
            'title' => function (\DOMXPath $x): ?string {
                foreach ([
                    '//h1[contains(@class,"classifiedDetailTitle")]',
                    '//h1[contains(@class,"classified-detail-title")]',
                    '//h1[contains(@class,"DetailTitle")]',
                    '//h1[@itemprop="name"]',
                    '//h1[contains(@class,"title")]',
                    '//meta[@property="og:title"]/@content',
                ] as $xp) {
                    $val = $this->xpathText($x, $xp);
                    if ($val && mb_strlen($val) > 3) return $val;
                }
                return null;
            },

            'price' => function (\DOMXPath $x, string $html): ?float {
                foreach ([
                    '//span[contains(@class,"price-value")]',
                    '//span[contains(@class,"classified-price-container")]',
                    '//div[contains(@class,"classifiedPrice")]//span',
                    '//span[@itemprop="price"]',
                    '//meta[@property="product:price:amount"]/@content',
                    '//meta[@itemprop="price"]/@content',
                ] as $xp) {
                    $raw = $this->xpathText($x, $xp);
                    if ($raw) {
                        $p = $this->parsePrice($raw);
                        if ($p > 0) return $p;
                    }
                }
                // Regex fallback: "450.000 TL" pattern
                if (preg_match('/(\d[\d\.\s]{3,})\s*TL\b/u', $html, $m)) {
                    $p = $this->parsePrice($m[1]);
                    if ($p > 1000) return $p; // Makul minimum fiyat
                }
                return null;
            },

            'description' => function (\DOMXPath $x): ?string {
                foreach ([
                    '//div[@id="classified_info_text"]',
                    '//div[contains(@class,"classifiedDescription")]',
                    '//div[contains(@class,"classified-description")]',
                    '//div[contains(@class,"description-text")]',
                    '//section[contains(@class,"description")]',
                    '//div[@itemprop="description"]',
                ] as $xp) {
                    $val = $this->xpathText($x, $xp);
                    if ($val && mb_strlen($val) > 10) return $val;
                }
                return null;
            },
        ] + $this->buildSpecExtractors();
    }

    private function buildSpecExtractors(): array
    {
        $extractors = [];
        foreach (self::SPEC_MAP as $label => $field) {
            $extractors[$field] = function (\DOMXPath $x, string $html) use ($label): ?string {
                // Yapı 1: <table class="classifiedInfoList"><tr><th>Label</th><td>Value</td></tr>
                $nodes = $x->query(
                    '//table[contains(@class,"classifiedInfoList")]//tr[th[normalize-space(text())="' . $label . '"]]/td[1]'
                );
                if ($nodes && $nodes->length > 0) {
                    return $this->cleanText($nodes->item(0)->textContent);
                }

                // Yapı 2: <li data-label="Label"><span class="value">...</span>
                $nodes = $x->query(
                    '//*[@data-label="' . $label . '"]//*[contains(@class,"value")]'
                );
                if ($nodes && $nodes->length > 0) {
                    return $this->cleanText($nodes->item(0)->textContent);
                }

                // Yapı 3: dl/dt/dd
                $nodes = $x->query(
                    '//dl[contains(@class,"classifiedInfo")]//dt[normalize-space(text())="' . $label . '"]/following-sibling::dd[1]'
                );
                if ($nodes && $nodes->length > 0) {
                    return $this->cleanText($nodes->item(0)->textContent);
                }

                // Yapı 4: classified-info-list li
                $nodes = $x->query(
                    '//*[contains(@class,"classified-info-list")]//li[.//span[normalize-space(text())="' . $label . '"]]//span[last()]'
                );
                if ($nodes && $nodes->length > 0) {
                    return $this->cleanText($nodes->item(0)->textContent);
                }

                // Regex fallback (HTML etiketleri arası)
                $escapedLabel = preg_quote($label, '/');
                if (preg_match(
                    '/' . $escapedLabel . '\s*<\/[^>]+>\s*(?:<[^>]+>)+\s*([^<]{2,80})</u',
                    $html,
                    $m
                )) {
                    $val = $this->cleanText($m[1]);
                    if (mb_strlen($val) >= 1) return $val;
                }

                return null;
            };
        }
        return $extractors;
    }

    /** XPath sorgusu çalıştırır, ilk eşleşen düğümün temizlenmiş metnini döner */
    private function xpathText(\DOMXPath $x, string $xp): ?string
    {
        $nodes = $x->query($xp);
        if (!$nodes || $nodes->length === 0) return null;
        $node = $nodes->item(0);
        $text = $node->textContent ?? $node->nodeValue ?? '';
        $text = $this->cleanText($text);
        return $text !== '' ? $text : null;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Görsel URL çıkarma
    // ─────────────────────────────────────────────────────────────────────────

    private function extractImageUrls(\DOMXPath $xpath, string $html, ?array $jsonLd): array
    {
        $urls = [];

        // JSON-LD kaynaklı görseller önce
        if ($jsonLd) {
            $ldImages = $jsonLd['_jsonld_images'] ?? (
                is_array($jsonLd['image'] ?? null)
                    ? $jsonLd['image']
                    : (is_string($jsonLd['image'] ?? null) ? [$jsonLd['image']] : [])
            );
            foreach ($ldImages as $u) {
                if (is_string($u) && $this->isValidImageUrl($u)) $urls[] = $u;
            }
        }

        // DOM: src ve lazy attributes
        $attrs = ['src', 'data-src', 'data-lazy-src', 'data-original', 'data-image-src'];
        $xpaths = [
            '//div[contains(@class,"classified-img-gallery")]//img',
            '//div[contains(@class,"classifiedDetailMainPhoto")]//img',
            '//div[contains(@class,"swiper-slide")]//img',
            '//ul[contains(@class,"classified-img-thumbs")]//img',
            '//div[contains(@class,"gallery")]//img',
            '//div[contains(@class,"photos")]//img',
        ];

        foreach ($xpaths as $xp) {
            $nodes = $xpath->query($xp);
            if (!$nodes) continue;
            foreach ($nodes as $node) {
                foreach ($attrs as $attr) {
                    $src = $node->getAttribute($attr);
                    if ($src && $this->isValidImageUrl($src)) {
                        $urls[] = $src;
                    }
                }
            }
        }

        // Regex fallback: Sahibinden CDN URL'leri
        if (preg_match_all(
            '/https?:\/\/(?:i\d+\.sdncdn\.com|cdn\.sahibinden\.com)[^\s"\'<>]+\.(?:jpe?g|png|webp)/ui',
            $html,
            $m
        )) {
            foreach ($m[0] as $u) $urls[] = $u;
        }

        // Temizlik: tekrar kaldır + thumbnail filtrele
        $urls = array_unique($urls);
        $urls = array_values(array_filter($urls, fn ($u) =>
            !str_contains($u, '/thumb/')
            && !str_contains($u, '/mini/')
            && !str_contains($u, '_thumb.')
            && !str_contains($u, 'logo')
            && !str_contains($u, 'avatar')
        ));

        // İndirecekten fazla tut (bazı başarısız olabilir)
        return array_slice($urls, 0, self::MAX_IMAGES * 4);
    }

    private function isValidImageUrl(string $url): bool
    {
        return strlen($url) > 15
            && str_starts_with($url, 'http')
            && filter_var($url, FILTER_VALIDATE_URL)
            && preg_match('/\.(jpe?g|png|webp|gif)(\?.*)?$/i', $url);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Görsel indirme — boyut korumalı + düzgün sayaç
    // ─────────────────────────────────────────────────────────────────────────

    private function downloadImages(array $urls): array
    {
        $downloaded  = [];
        $totalTried  = 0;
        $maxAttempts = self::MAX_IMAGES * 3; // Geniş pencere: bazı URL'ler başarısız olabilir

        foreach ($urls as $url) {
            if (count($downloaded) >= self::MAX_IMAGES) break;
            if ($totalTried >= $maxAttempts) break;
            $totalTried++;

            try {
                $result = $this->fetchImageSafe($url);
                if (!$result) continue;

                [$content, $mime] = $result;

                $ext      = $this->mimeToExt($mime);
                $filename = self::TMP_PREFIX . Str::random(14) . '.' . $ext;
                $path     = 'vehicles/' . $filename;

                Storage::disk('public')->put($path, $content);
                $downloaded[] = $path;
            } catch (\Throwable $e) {
                Log::warning('Sahibinden görsel indirilemedi', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Sahibinden import', [
            'images_downloaded' => count($downloaded),
            'urls_tried'        => $totalTried,
        ]);

        return $downloaded;
    }

    /**
     * Görsel indirir, boyut ve MIME kontrolü yapar.
     * Başarısız veya boyut aşımında null döner.
     *
     * @return array{string, string}|null [içerik, mime_type]
     */
    private function fetchImageSafe(string $url): ?array
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 2,
            CURLOPT_TIMEOUT        => self::MAX_IMAGE_TIMEOUT,
            CURLOPT_USERAGENT      => self::USER_AGENT,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING       => '',
            // Boyut koruması: header ile Content-Length kontrolü
            CURLOPT_HEADERFUNCTION => function ($ch, $header) {
                if (preg_match('/content-length:\s*(\d+)/i', $header, $m)) {
                    if ((int) $m[1] > self::MAX_IMAGE_BYTES) {
                        // Aşırı büyük dosyayı iptal et (return 0 ile curl hataya düşer)
                        return 0;
                    }
                }
                return strlen($header);
            },
        ]);

        $content    = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$content || $statusCode !== 200 || strlen($content) < 500) return null;

        // İndirilen içeriğin boyut kontrolü
        if (strlen($content) > self::MAX_IMAGE_BYTES) return null;

        // MIME tipi doğrulama (güvenilir)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_buffer($finfo, $content);
        finfo_close($finfo);

        if (!str_starts_with($mime, 'image/')) return null;

        return [$content, $mime];
    }

    private function mimeToExt(string $mime): string
    {
        return match (true) {
            str_contains($mime, 'jpeg') => 'jpg',
            str_contains($mime, 'png')  => 'png',
            str_contains($mime, 'webp') => 'webp',
            str_contains($mime, 'gif')  => 'gif',
            default                     => 'jpg',
        };
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Catalog eşleştirme — CarBrand / CarModel
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Çekilen marka/model metnini mevcut catalog ile eşleştirmeye çalışır.
     * Eşleşme bulunamazsa null döner — form alanına ham değer yazılır.
     */
    private function matchCatalog(?string $rawBrand, ?string $rawModel): array
    {
        $result = ['brand_match' => null, 'model_match' => null];

        if (!$rawBrand) return $result;

        // Marka arama: büyük/küçük harf ve kısa kırpma
        $brand = CarBrand::where('name', 'LIKE', '%' . trim($rawBrand) . '%')
            ->orWhereRaw('LOWER(name) = LOWER(?)', [$rawBrand])
            ->first();

        if (!$brand) {
            // Kısmi eşleşme: sadece ilk kelime
            $firstWord = explode(' ', trim($rawBrand))[0];
            $brand     = CarBrand::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($firstWord) . '%'])->first();
        }

        if ($brand) {
            $result['brand_match'] = $brand->name;

            // Model arama
            if ($rawModel) {
                $model = CarModel::where('car_brand_id', $brand->id)
                    ->where(function ($q) use ($rawModel) {
                        $q->where('name', 'LIKE', '%' . trim($rawModel) . '%')
                          ->orWhereRaw('LOWER(name) = LOWER(?)', [$rawModel]);
                    })->first();

                if ($model) {
                    $result['model_match'] = $model->name;
                }
            }
        }

        return $result;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Orphan temizliği
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Önceki import'un kaydedilmemiş görsellerini temizler.
     * Bir sonraki import başlamadan önce çağrılır.
     */
    public function cleanupOrphanImages(): void
    {
        $pending = session()->pull(self::SESSION_KEY, []);

        foreach ($pending as $path) {
            try {
                if (str_contains($path, self::TMP_PREFIX) && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            } catch (\Throwable) {
                // Temizleme hatası kritik değil, devam et
            }
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Normalizasyon
    // ─────────────────────────────────────────────────────────────────────────

    private function normalizeNumericFields(array $data): array
    {
        if (isset($data['year'])) {
            $y = (int) preg_replace('/\D/', '', (string) $data['year']);
            $data['year'] = ($y >= 1980 && $y <= (int) date('Y') + 1) ? $y : null;
        }
        if (isset($data['kilometer'])) {
            $km = (int) preg_replace('/\D/', '', (string) $data['kilometer']);
            $data['kilometer'] = ($km >= 0 && $km <= 2_000_000) ? $km : null;
        }
        if (isset($data['price'])) {
            $p = $this->parsePrice((string) $data['price']);
            $data['price'] = ($p > 0) ? $p : null;
        }
        if (isset($data['horse_power'])) {
            $hp = (int) preg_replace('/\D/', '', (string) $data['horse_power']);
            $data['horse_power'] = ($hp > 0 && $hp < 3000) ? $hp : null;
        }
        if (isset($data['door_count'])) {
            $d = (int) preg_replace('/\D/', '', (string) $data['door_count']);
            $data['door_count'] = ($d >= 2 && $d <= 8) ? $d : null;
        }
        if (isset($data['seat_count'])) {
            $s = (int) preg_replace('/\D/', '', (string) $data['seat_count']);
            $data['seat_count'] = ($s >= 2 && $s <= 15) ? $s : null;
        }
        return $data;
    }

    private function normalizeFieldValues(array $data): array
    {
        if (!empty($data['fuel_type'])) {
            $ft = $data['fuel_type'];
            $data['fuel_type'] = match (true) {
                str_contains($ft, 'Dizel')                                   => 'Dizel',
                str_contains($ft, 'Benzin') && str_contains($ft, 'LPG')     => 'LPG/Benzin',
                str_contains($ft, 'Benzin') && str_contains($ft, 'Elektrik') => 'Hibrit',
                str_contains($ft, 'Benzin')                                  => 'Benzin',
                str_contains($ft, 'Hybrid') || str_contains($ft, 'Hibrit')  => 'Hibrit',
                str_contains($ft, 'Elektrik')                                => 'Elektrikli',
                default                                                       => $ft,
            };
        }

        if (!empty($data['transmission'])) {
            $tr = $data['transmission'];
            $data['transmission'] = match (true) {
                str_contains($tr, 'Otomatik') => 'Otomatik',
                str_contains($tr, 'Manuel')   => 'Manuel',
                str_contains($tr, 'Yarı')     => 'Yarı Otomatik',
                default                       => $tr,
            };
        }

        if (!empty($data['drive_type'])) {
            $dr = $data['drive_type'];
            $data['drive_type'] = match (true) {
                str_contains($dr, 'Önden')  => 'Önden Çekiş',
                str_contains($dr, 'Arkadan') => 'Arkadan İtiş',
                str_contains($dr, '4x4') || str_contains($dr, 'Dört') => '4x4',
                default                     => $dr,
            };
        }

        // Başlık yoksa bileşik oluştur
        if (empty($data['title']) && !empty($data['brand'])) {
            $parts = array_filter([
                $data['brand']           ?? null,
                $data['model']           ?? null,
                $data['package_version'] ?? null,
                $data['year']            ?? null,
            ]);
            $data['title'] = implode(' ', $parts);
        }

        return $data;
    }

    /** Uzun metin alanlarını DB limitlerine göre kırp */
    private function applyTextLimits(array $data): array
    {
        $limits = [
            'title'           => 255,
            'brand'           => 100,
            'model'           => 100,
            'package_version' => 100,
            'color'           => 80,
            'fuel_type'       => 50,
            'transmission'    => 50,
            'body_type'       => 80,
            'drive_type'      => 50,
            'engine_size'     => 50,
        ];

        foreach ($limits as $field => $maxLen) {
            if (!empty($data[$field]) && is_string($data[$field]) && mb_strlen($data[$field]) > $maxLen) {
                $data[$field] = mb_substr($data[$field], 0, $maxLen);
            }
        }

        if (!empty($data['description']) && mb_strlen($data['description']) > 10000) {
            $data['description'] = mb_substr($data['description'], 0, 10000);
        }

        return $data;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Yardımcılar
    // ─────────────────────────────────────────────────────────────────────────

    private function parsePrice(string $raw): float
    {
        $clean = preg_replace('/[^\d,\.]/', '', $raw);
        if (empty($clean)) return 0.0;

        // Türkçe format: 450.000,00
        if (preg_match('/^[\d.]+,\d{1,2}$/', $clean)) {
            $clean = str_replace(['.', ','], ['', '.'], $clean);
        } else {
            // Binlik nokta: 450.000
            $clean = str_replace('.', '', $clean);
            $clean = str_replace(',', '.', $clean);
        }

        return (float) $clean;
    }

    private function parseKm(mixed $raw): int
    {
        return (int) preg_replace('/\D/', '', (string) $raw);
    }

    private function cleanText(string $text): string
    {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[\x00-\x1F\x7F]/u', ' ', $text); // kontrol karakterleri
        $text = preg_replace('/\s+/u', ' ', $text);
        return trim($text);
    }
}
