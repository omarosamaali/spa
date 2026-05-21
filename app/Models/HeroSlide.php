<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    protected $fillable = [
        'sort_order', 'type', 'media_url', 'media_path', 'media_url_alt',
        'poster_url', 'poster_path', 'badge', 'title', 'title_highlight', 'subtitle',
        'btn_primary_text', 'btn_primary_url', 'btn_secondary_text', 'btn_secondary_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function mediaSrc(): string
    {
        if ($this->media_path && Storage::disk('public')->exists($this->media_path)) {
            return asset('storage/' . $this->media_path);
        }

        return $this->media_url ?? '';
    }

    public function mediaSrcAlt(): ?string
    {
        return $this->media_url_alt;
    }

    public function posterSrc(): ?string
    {
        if ($this->poster_path && Storage::disk('public')->exists($this->poster_path)) {
            return asset('storage/' . $this->poster_path);
        }

        return $this->poster_url;
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }
}
