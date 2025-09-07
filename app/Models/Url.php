<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Url extends Model
{
    protected $fillable = ['original_url', 'short_code', 'expires_at'];
    
    protected $casts = [
        'expires_at' => 'datetime',
    ];
    
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
    
    public static function findByShortCode(string $code): ?self
    {
        return static::where('short_code', $code)->first();
    }
    
    public static function findByOriginalUrl(string $url): ?self
    {
        return static::where('original_url', $url)->first();
    }
}