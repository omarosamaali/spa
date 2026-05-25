<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $fillable = [
        'name', 'category', 'capacity', 'notes', 'is_active', 'sort_order',
    ];

    protected $attributes = [
        'capacity' => 1,
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public static function categoryLabels(): array
    {
        return Service::categoryLabelsForAdmin();
    }
}
