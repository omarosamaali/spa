<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function defaults(): array
    {
        return [
            'hero_video_url'     => 'https://videos.pexels.com/video-files/3209828/3209828-hd_1920_1080_25fps.mp4',
            'hero_video_url_alt' => 'https://videos.pexels.com/video-files/3214436/3214436-hd_1920_1080_25fps.mp4',
            'hero_video_poster'  => 'https://images.unsplash.com/photo-1583416750470-965b2707b355?w=1920&q=60&auto=format&fit=crop',
        ];
    }

    public static function tableReady(): bool
    {
        try {
            return Schema::hasTable('site_settings');
        } catch (\Throwable) {
            return false;
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        if (! static::tableReady()) {
            return $default ?? (static::defaults()[$key] ?? null);
        }

        return Cache::remember("site_setting_{$key}", 3600, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        if (! static::tableReady()) {
            return;
        }

        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("site_setting_{$key}");
        if (str_starts_with($key, 'hero_video')) {
            static::clearHeroVideoCache();
        }
    }

    public static function heroVideo(): array
    {
        $defaults = static::defaults();

        if (! static::tableReady()) {
            return [
                'src'     => $defaults['hero_video_url'],
                'src_alt' => $defaults['hero_video_url_alt'],
                'poster'  => $defaults['hero_video_poster'],
                'path'    => null,
                'url'     => $defaults['hero_video_url'],
            ];
        }

        return Cache::remember('site_setting_hero_video', 3600, function () use ($defaults) {
            $path = static::where('key', 'hero_video_path')->value('value');

            $url = static::where('key', 'hero_video_url')->value('value') ?? $defaults['hero_video_url'];
            $urlAlt = static::where('key', 'hero_video_url_alt')->value('value') ?? $defaults['hero_video_url_alt'];
            $poster = static::where('key', 'hero_video_poster')->value('value') ?? $defaults['hero_video_poster'];

            if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                $src = asset('storage/' . $path);
            } else {
                $src = $url;
            }

            return [
                'src'      => $src,
                'src_alt'  => $urlAlt,
                'poster'   => $poster,
                'path'     => $path,
                'url'      => $url,
            ];
        });
    }

    public static function clearHeroVideoCache(): void
    {
        Cache::forget('site_setting_hero_video');
        foreach (['hero_video_url', 'hero_video_url_alt', 'hero_video_poster', 'hero_video_path'] as $key) {
            Cache::forget("site_setting_{$key}");
        }
    }
}
