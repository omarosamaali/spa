<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'icon', 'description', 'price',
        'duration_minutes', 'category', 'image',
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Category keys => Arabic labels (booking, admin, homepage tabs).
     */
    public static function categoryLabels(): array
    {
        return [
            'laser'   => 'الليزر',
            'skin'    => 'البشرة',
            'botox'   => 'البوتوكس والفيلر',
            'massage' => 'المساج',
            'nails'   => 'الأظافر',
            'hair'    => 'الشعر',
            'makeup'  => 'المكياج',
            'other'   => 'أخرى',
        ];
    }

    public static function categoryLabel(?string $key): string
    {
        if (! $key) {
            return 'أخرى';
        }

        return static::categoryLabels()[$key] ?? $key;
    }
}
