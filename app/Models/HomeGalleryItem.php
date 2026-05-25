<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeGalleryItem extends Model
{
    protected $fillable = [
        'image', 'alt', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function imageUrl(): string
    {
        return asset('storage/'.$this->image);
    }

    /** @return list<array{url: string, alt: string}> */
    public static function defaultPlaceholders(): array
    {
        return [
            ['url' => 'https://images.unsplash.com/photo-1583416750470-965b2707b355?w=600&h=450&q=80&auto=format&fit=crop', 'alt' => 'قاعة السبا الفاخرة'],
            ['url' => 'https://images.unsplash.com/photo-1563788240-4a32624c5e46?w=600&h=450&q=80&auto=format&fit=crop', 'alt' => 'أحجار الاسترخاء'],
            ['url' => 'https://images.unsplash.com/photo-1556760544-74068565f05c?w=600&h=450&q=80&auto=format&fit=crop', 'alt' => 'منتجات العناية'],
            ['url' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600&h=450&q=80&auto=format&fit=crop', 'alt' => 'كريمات البشرة'],
            ['url' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=600&h=450&q=80&auto=format&fit=crop', 'alt' => 'أجواء السبا'],
            ['url' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&h=450&q=80&auto=format&fit=crop', 'alt' => 'غرفة الاسترخاء'],
        ];
    }
}
