<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'icon', 'description', 'price',
        'duration_minutes', 'category', 'equipment_id', 'image',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'service_staff');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /** تصنيفات نشطة — للفلتر والحجز والموقع */
    public static function categoryLabels(): array
    {
        return ServiceCategory::labelsMap(activeOnly: true);
    }

    /** كل التصنيفات — لنماذج اللوحة (بما فيها المعطّلة) */
    public static function categoryLabelsForAdmin(): array
    {
        return ServiceCategory::labelsMap(activeOnly: false);
    }

    public static function categoryLabel(?string $key): string
    {
        return ServiceCategory::labelFor($key);
    }

    /**
     * Old single-row "category as service" names — hidden from booking once sub-services exist.
     */
    public static function legacyParentNames(): array
    {
        return [
            'الليزر',
            'البشرة',
            'البوتوكس والفيلر',
            'المساج',
            'الأظافر',
        ];
    }

    public function scopeBookable($query)
    {
        return $query->where('is_active', true)
            ->whereNotIn('name', static::legacyParentNames())
            ->orderBy('sort_order');
    }

    /**
     * Stock photos per category (used when no custom image uploaded).
     */
    public static function categoryStockImages(): array
    {
        return [
            'laser'   => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=800&h=1000&q=85&auto=format&fit=crop',
            'skin'    => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=800&h=1000&q=85&auto=format&fit=crop',
            'massage' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&h=1000&q=85&auto=format&fit=crop',
            'botox'   => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&h=1000&q=85&auto=format&fit=crop',
            'nails'   => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=800&h=1000&q=85&auto=format&fit=crop',
            'hair'    => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=800&h=1000&q=85&auto=format&fit=crop',
            'makeup'  => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=800&h=1000&q=85&auto=format&fit=crop',
            'other'   => 'https://images.unsplash.com/photo-1519415517519-46d9653ae0a4?w=800&h=1000&q=85&auto=format&fit=crop',
        ];
    }

    public static function categoryStockImage(?string $category): string
    {
        $images = static::categoryStockImages();

        return $images[$category ?? ''] ?? $images['skin'];
    }

    /** Image for public cards: uploaded photo first, then category stock. */
    public function displayImageUrl(): string
    {
        if ($this->image) {
            return asset('storage/'.$this->image);
        }

        return static::categoryStockImage($this->category);
    }
}
