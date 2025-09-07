<?php
namespace App\Services;

use App\Models\Url;
use Carbon\Carbon;

class UrlShortenerService
{
    public function shortenUrl(string $originalUrl, ?int $ttlMinutes = null): array
    {
        // Validate and normalize URL
        $normalizedUrl = $this->normalizeUrl($originalUrl);
        
        // Check for existing URL (deduplication)
        $existingUrl = Url::findByOriginalUrl($normalizedUrl);
        if ($existingUrl && !$existingUrl->isExpired()) {
            return $this->formatResponse($existingUrl);
        }
        
        // Generate unique short code
        $shortCode = $this->generateUniqueShortCode();
        
        // Calculate expiration
        $expiresAt = $ttlMinutes ? Carbon::now()->addMinutes($ttlMinutes) : null;
        
        // Save to database
        $url = Url::create([
            'original_url' => $normalizedUrl,
            'short_code' => $shortCode,
            'expires_at' => $expiresAt,
        ]);
        
        return $this->formatResponse($url);
    }
    
    private function normalizeUrl(string $url): string
    {
        // Add scheme if missing
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }
        
        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL provided');
        }
        
        return $url;
    }
    
    private function generateUniqueShortCode(): string
    {
        $attempts = 0;
        $maxAttempts = 10;
        
        do {
            $shortCode = $this->generateShortCode();
            $attempts++;
            
            if ($attempts > $maxAttempts) {
                throw new \RuntimeException('Unable to generate unique short code');
            }
        } while (Url::where('short_code', $shortCode)->exists());
        
        return $shortCode;
    }
    
    private function generateShortCode(int $length = 6): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $shortCode = '';
        
        for ($i = 0; $i < $length; $i++) {
            $shortCode .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $shortCode;
    }
    
    private function formatResponse(Url $url): array
    {
        return [
            'short_code' => $url->short_code,
            'short_url' => url("/u/{$url->short_code}"),
            'original_url' => $url->original_url,
            'expires_at' => $url->expires_at?->toISOString(),
        ];
    }
}