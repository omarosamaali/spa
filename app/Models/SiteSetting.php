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
            'contact_phone'          => '+964 770 123 4567',
            'contact_phone_raw'      => '9647701234567',
            'contact_whatsapp_phone' => '+964 770 123 4567',
            'contact_whatsapp_raw'   => '9647701234567',
            'contact_email'          => 'info@nayspa.iq',
            'contact_address'        => 'بغداد - المنصور - شارع 14 رمضان',
            'contact_hours_weekdays' => '10:00 ص — 10:00 م',
            'contact_hours_friday'   => '2:00 م — 10:00 م',
            'whatsapp_default_text'  => 'مرحباً، أريد الاستفسار عن خدمات NAY SPA',
            'social_instagram'       => '',
            'social_facebook'        => '',
            'social_tiktok'          => '',
            'social_snapchat'        => '',
        ];
    }

    public static function socialPlatforms(): array
    {
        return [
            'instagram' => ['label' => 'Instagram', 'color' => '#e1306c', 'bg' => 'rgba(225,48,108,0.1)', 'border' => 'rgba(225,48,108,0.2)'],
            'facebook'  => ['label' => 'Facebook', 'color' => '#1877f2', 'bg' => 'rgba(24,119,242,0.1)', 'border' => 'rgba(24,119,242,0.2)'],
            'tiktok'    => ['label' => 'TikTok', 'color' => '#ffffff', 'bg' => 'rgba(255,255,255,0.08)', 'border' => 'rgba(255,255,255,0.15)'],
            'snapchat'  => ['label' => 'Snapchat', 'color' => '#fffc00', 'bg' => 'rgba(255,252,0,0.1)', 'border' => 'rgba(255,252,0,0.2)'],
        ];
    }

    public static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);
        if (str_starts_with($digits, '0')) {
            $digits = '964' . ltrim($digits, '0');
        } elseif (! str_starts_with($digits, '964')) {
            $digits = '964' . $digits;
        }

        return $digits;
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
        if (str_starts_with($key, 'contact_') || str_starts_with($key, 'whatsapp_') || str_starts_with($key, 'social_')) {
            static::clearContactCache();
        }
    }

    public static function buildContactPayload(array $values): array
    {
        $defaults = static::defaults();
        $phoneDisplay = $values['contact_phone'] ?? $defaults['contact_phone'];
        $phoneRawInput = trim($values['contact_phone_raw'] ?? $defaults['contact_phone_raw'] ?? '');
        $phoneRaw = static::normalizePhone($phoneRawInput !== '' ? $phoneRawInput : $phoneDisplay);

        $waDisplay = trim($values['contact_whatsapp_phone'] ?? '') ?: $phoneDisplay;
        $waRawInput = trim($values['contact_whatsapp_raw'] ?? '');
        if ($waRawInput === '') {
            $waRawInput = $phoneRawInput !== '' ? $phoneRawInput : $phoneRaw;
        }
        $waRaw = static::normalizePhone($waRawInput ?: $waDisplay);
        $waText = $values['whatsapp_default_text'] ?? $defaults['whatsapp_default_text'];
        $email = $values['contact_email'] ?? $defaults['contact_email'];

        $social = [];
        foreach (static::socialPlatforms() as $key => $meta) {
            $url = trim($values['social_' . $key] ?? '');
            if ($url !== '') {
                $social[] = array_merge($meta, ['key' => $key, 'url' => $url]);
            }
        }

        return [
            'phone'              => $phoneDisplay,
            'phone_raw'          => $phoneRaw,
            'whatsapp_phone'     => $waDisplay,
            'whatsapp_raw'       => $waRaw,
            'whatsapp_url'       => 'https://wa.me/' . $waRaw . ($waText ? '?text=' . rawurlencode($waText) : ''),
            'whatsapp_url_plain' => 'https://wa.me/' . $waRaw,
            'tel_url'            => 'tel:+' . $phoneRaw,
            'email'              => $email,
            'mailto_url'         => 'mailto:' . $email,
            'address'            => $values['contact_address'] ?? $defaults['contact_address'],
            'hours_weekdays'     => $values['contact_hours_weekdays'] ?? $defaults['contact_hours_weekdays'],
            'hours_friday'       => $values['contact_hours_friday'] ?? $defaults['contact_hours_friday'],
            'whatsapp_text'      => $waText,
            'social'             => $social,
        ];
    }

    public static function contactInfo(): array
    {
        $defaults = static::defaults();

        if (! static::tableReady()) {
            return static::buildContactPayload($defaults);
        }

        return Cache::remember('site_setting_contact', 3600, function () use ($defaults) {
            $values = $defaults;
            foreach (array_keys($defaults) as $key) {
                if (str_starts_with($key, 'contact_') || str_starts_with($key, 'whatsapp_') || str_starts_with($key, 'social_')) {
                    $stored = static::where('key', $key)->value('value');
                    if ($stored !== null && $stored !== '') {
                        $values[$key] = $stored;
                    }
                }
            }

            return static::buildContactPayload($values);
        });
    }

    public static function clearContactCache(): void
    {
        Cache::forget('site_setting_contact');
        foreach (array_keys(static::defaults()) as $key) {
            if (str_starts_with($key, 'contact_') || str_starts_with($key, 'whatsapp_') || str_starts_with($key, 'social_')) {
                Cache::forget("site_setting_{$key}");
            }
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
