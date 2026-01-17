<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * Sahibinden.com API Entegrasyon Servisi
 * 
 * Bu servis, Sahibinden.com API'si ile iletişim kurmak için hazırlanmıştır.
 * API bilgileri geldiğinde bu servis kullanılacaktır.
 */
class SahibindenApiService
{
    private $baseUrl;
    private $apiKey;
    private $apiSecret;
    
    public function __construct()
    {
        $this->baseUrl = config('services.sahibinden.api_url', '');
        $this->apiKey = config('services.sahibinden.api_key', '');
        $this->apiSecret = config('services.sahibinden.api_secret', '');
    }
    
    /**
     * API bağlantısını test et
     * 
     * @return bool
     */
    public function testConnection(): bool
    {
        if (empty($this->baseUrl) || empty($this->apiKey)) {
            Log::warning('Sahibinden API credentials not configured');
            return false;
        }
        
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json',
                ])
                ->get($this->baseUrl . '/test');
            
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Sahibinden API connection test failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Araçları getir (filtrelerle)
     * 
     * @param array $filters
     * @return array|null
     */
    public function getVehicles(array $filters = []): ?array
    {
        if (empty($this->baseUrl) || empty($this->apiKey)) {
            Log::warning('Sahibinden API credentials not configured');
            return null;
        }
        
        try {
            $cacheKey = 'sahibinden_vehicles_' . md5(json_encode($filters));
            
            return Cache::remember($cacheKey, 300, function () use ($filters) {
                $response = Http::timeout(30)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Accept' => 'application/json',
                    ])
                    ->get($this->baseUrl . '/vehicles', $filters);
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                Log::error('Sahibinden API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return null;
            });
        } catch (\Exception $e) {
            Log::error('Sahibinden API getVehicles error', [
                'error' => $e->getMessage(),
                'filters' => $filters
            ]);
            return null;
        }
    }
    
    /**
     * Tek bir aracın detayını getir
     * 
     * @param string $vehicleId
     * @return array|null
     */
    public function getVehicleDetail(string $vehicleId): ?array
    {
        if (empty($this->baseUrl) || empty($this->apiKey)) {
            return null;
        }
        
        try {
            $cacheKey = 'sahibinden_vehicle_' . $vehicleId;
            
            return Cache::remember($cacheKey, 600, function () use ($vehicleId) {
                $response = Http::timeout(30)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Accept' => 'application/json',
                    ])
                    ->get($this->baseUrl . '/vehicles/' . $vehicleId);
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                return null;
            });
        } catch (\Exception $e) {
            Log::error('Sahibinden API getVehicleDetail error', [
                'error' => $e->getMessage(),
                'vehicle_id' => $vehicleId
            ]);
            return null;
        }
    }
    
    /**
     * API bilgilerinin yapılandırılmış olup olmadığını kontrol et
     * 
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->baseUrl) && !empty($this->apiKey);
    }
}
