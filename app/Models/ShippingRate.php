<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'continent',
        'label',
        'rate',
        'is_active',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get rate for a given continent slug.
     */
    public static function getRateForContinent(string $continent): float
    {
        $record = static::where('continent', $continent)->where('is_active', true)->first();
        return $record ? (float) $record->rate : 0;
    }

    /**
     * Get all active rates as continent => rate array for JS.
     */
    public static function getActiveRatesMap(): array
    {
        return static::where('is_active', true)
            ->pluck('rate', 'continent')
            ->toArray();
    }
}
