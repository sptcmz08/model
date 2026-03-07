<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'link',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            $path = str_replace('storage/', '', $this->image_path);
            return url('media/' . $path);
        }
        return asset('images/placeholder.svg');
    }
}
