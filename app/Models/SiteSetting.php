<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
// SiteTheme is in same namespace - no explicit use needed

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
            'theme_primary'          => '#e8b4b8',
            'theme_primary_dark'     => '#c9888e',
            'theme_primary_light'    => '#f5dfe1',
            'theme_gold'             => '#c9a96e',
            'theme_dark'             => '#1a1a1a',
            'theme_dark_2'           => '#2a2a2a',
            'site_name'              => 'NAY SPA',
            'site_tagline'           => 'جمالك يستحق العناية',
            'logo_path'              => '',
            'favicon_path'           => '',
            'active_theme'           => 'luxea',
            'promo_active'           => '1',
            'promo_badge'            => 'عرض خاص لأول مرة',
            'promo_title'            => 'جاهزة للتجربة؟',
            'promo_line1'            => 'احجزي موعدك الآن',
            'promo_line2'            => 'واستمتعي بتجربة عناية فاخرة',
            'promo_discount'         => '15%',
            'promo_discount_label'   => 'خصم خاص',
            'promo_discount_note'    => 'على جميع الخدمات للحجوزات الأولى',
            'promo_image'            => '',
            'promo_button_text'      => 'احجزي الآن',
            'promo_button_url'       => '',
            'steps_video_url'        => '',
            'steps_video_path'       => '',
            'steps_video_poster'     => '',
        ];
    }

    public static function stepsVideoKeys(): array
    {
        return ['steps_video_url', 'steps_video_path', 'steps_video_poster'];
    }

    public static function promoKeys(): array
    {
        return [
            'promo_active', 'promo_badge', 'promo_title', 'promo_line1', 'promo_line2',
            'promo_discount', 'promo_discount_label', 'promo_discount_note',
            'promo_image', 'promo_button_text', 'promo_button_url',
        ];
    }

    public static function defaultPromoImage(): string
    {
        return 'https://images.unsplash.com/photo-1556760544-74068565f05c?w=800&h=400&q=80&auto=format&fit=crop';
    }

    public static function themeKeys(): array
    {
        return [
            'theme_primary', 'theme_primary_dark', 'theme_primary_light',
            'theme_gold', 'theme_dark', 'theme_dark_2',
            'site_name', 'site_tagline', 'logo_path', 'favicon_path',
            'active_theme',
        ];
    }

    public static function normalizeHexColor(string $color): string
    {
        $color = trim($color);
        if (! str_starts_with($color, '#')) {
            $color = '#' . $color;
        }

        return strtolower($color);
    }

    public static function assetUrl(?string $path): ?string
    {
        if (! $path || ! Storage::disk('public')->exists($path)) {
            return null;
        }

        return asset('storage/' . $path);
    }

    public static function theme(): array
    {
        if (! static::tableReady()) {
            return SiteTheme::buildPayload(SiteTheme::getById('luxea'));
        }

        return Cache::remember('site_setting_theme', 3600, function () {
            $activeId = static::where('key', 'active_theme')->value('value') ?: 'luxea';
            $preset   = SiteTheme::getById($activeId);

            $overrides = [];
            foreach (static::themeKeys() as $key) {
                $stored = static::where('key', $key)->value('value');
                if ($stored !== null && $stored !== '') {
                    $overrides[$key] = $stored;
                }
            }

            $merged = SiteTheme::mergeWithCustom($preset, $overrides);

            return SiteTheme::buildPayload($merged);
        });
    }

    /**
     * Build a one-off theme payload for a given theme ID without touching the DB.
     * Used by the preview route.
     */
    public static function themeForPreview(string $themeId): array
    {
        $preset = SiteTheme::getById($themeId);

        // Still merge logo/favicon from DB so previews show the real logo
        $overrides = [];
        foreach (['logo_path', 'favicon_path', 'site_name'] as $key) {
            $stored = static::get($key);
            if ($stored) $overrides[$key] = $stored;
        }

        $merged = SiteTheme::mergeWithCustom($preset, $overrides);

        return SiteTheme::buildPayload($merged);
    }

    /**
     * @deprecated Use SiteTheme::buildPayload() instead.
     */
    public static function buildThemePayload(array $values): array
    {
        $primary     = static::normalizeHexColor($values['theme_primary'] ?? '#e8b4b8');
        $primaryDark = static::normalizeHexColor($values['theme_primary_dark'] ?? '#c9888e');
        $logoPath    = $values['logo_path'] ?? '';
        $faviconPath = $values['favicon_path'] ?? '';

        return [
            'id'               => $values['active_theme'] ?? 'luxea',
            'name'             => $values['site_name'] ?? 'NAY SPA',
            'tagline'          => $values['site_tagline'] ?? 'جمالك يستحق العناية',
            'dark_mode'        => true,
            'primary'          => $primary,
            'primary_dark'     => $primaryDark,
            'primary_light'    => static::normalizeHexColor($values['theme_primary_light'] ?? '#f5dfe1'),
            'gold'             => static::normalizeHexColor($values['theme_gold'] ?? '#c9a96e'),
            'dark'             => static::normalizeHexColor($values['theme_dark'] ?? '#1a1a1a'),
            'dark_2'           => static::normalizeHexColor($values['theme_dark_2'] ?? '#2a2a2a'),
            'dark_3'           => static::normalizeHexColor($values['theme_dark'] ?? '#1a1a1a'),
            'text_body'        => '#e8e0dd',
            'hero_gradient'    => '',
            'nav_gradient'     => '',
            'preview_colors'   => [$primary, $primaryDark],
            'site_name'        => $values['site_name'] ?? 'NAY SPA',
            'logo_url'         => static::assetUrl($logoPath),
            'favicon_url'      => static::assetUrl($faviconPath),
            'has_logo'         => (bool) static::assetUrl($logoPath),
            'has_favicon'      => (bool) static::assetUrl($faviconPath),
        ];
    }

    public static function clearThemeCache(): void
    {
        Cache::forget('site_setting_theme');
        foreach (static::themeKeys() as $key) {
            Cache::forget("site_setting_{$key}");
        }
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
        if (str_starts_with($key, 'steps_video')) {
            static::clearStepsVideoCache();
        }
        if (str_starts_with($key, 'contact_') || str_starts_with($key, 'whatsapp_') || str_starts_with($key, 'social_')) {
            static::clearContactCache();
        }
        if (str_starts_with($key, 'promo_')) {
            static::clearPromoCache();
        }
        if (in_array($key, static::themeKeys(), true)) {
            static::clearThemeCache();
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

    public static function buildPromoPayload(array $values): array
    {
        $defaults = static::defaults();
        $imagePath = trim($values['promo_image'] ?? '');
        $buttonUrl = trim($values['promo_button_url'] ?? '');

        return [
            'active'          => ($values['promo_active'] ?? '1') === '1',
            'badge'           => $values['promo_badge'] ?? $defaults['promo_badge'],
            'title'           => $values['promo_title'] ?? $defaults['promo_title'],
            'line1'           => $values['promo_line1'] ?? $defaults['promo_line1'],
            'line2'           => $values['promo_line2'] ?? $defaults['promo_line2'],
            'discount'        => $values['promo_discount'] ?? $defaults['promo_discount'],
            'discount_label'  => $values['promo_discount_label'] ?? $defaults['promo_discount_label'],
            'discount_note'   => $values['promo_discount_note'] ?? $defaults['promo_discount_note'],
            'image_url'       => static::assetUrl($imagePath) ?: static::defaultPromoImage(),
            'has_image'       => (bool) static::assetUrl($imagePath),
            'button_text'     => $values['promo_button_text'] ?? $defaults['promo_button_text'],
            'button_url'      => $buttonUrl !== '' ? $buttonUrl : '/booking',
        ];
    }

    public static function promoBanner(): array
    {
        $defaults = static::defaults();

        if (! static::tableReady()) {
            return static::buildPromoPayload($defaults);
        }

        return Cache::remember('site_setting_promo', 3600, function () use ($defaults) {
            $values = $defaults;
            foreach (static::promoKeys() as $key) {
                $stored = static::where('key', $key)->value('value');
                if ($stored !== null && $stored !== '') {
                    $values[$key] = $stored;
                }
            }

            return static::buildPromoPayload($values);
        });
    }

    public static function clearPromoCache(): void
    {
        Cache::forget('site_setting_promo');
        foreach (static::promoKeys() as $key) {
            Cache::forget("site_setting_{$key}");
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

    /**
     * Resolve YouTube/Vimeo URL to embed src, or null if direct file URL.
     *
     * @return array{type: 'embed'|'file', src: string, poster?: string}|null
     */
    public static function resolveVideoSource(string $url, ?string $poster = null): ?array
    {
        $url = trim($url);
        if ($url === '') {
            return null;
        }

        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([a-zA-Z0-9_-]{11})~', $url, $m)) {
            return [
                'type' => 'embed',
                'src'  => 'https://www.youtube.com/embed/' . $m[1] . '?rel=0&modestbranding=1',
            ];
        }

        if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $m)) {
            return [
                'type' => 'embed',
                'src'  => 'https://player.vimeo.com/video/' . $m[1],
            ];
        }

        return [
            'type'   => 'file',
            'src'    => $url,
            'poster' => $poster ?: null,
        ];
    }

    public static function buildStepsVideoPayload(array $values): array
    {
        $path = trim($values['steps_video_path'] ?? '');
        $url = trim($values['steps_video_url'] ?? '');
        $poster = trim($values['steps_video_poster'] ?? '');

        if ($path && Storage::disk('public')->exists($path)) {
            $fileSrc = asset('storage/' . $path);
            $source = static::resolveVideoSource($fileSrc, $poster ?: null) ?? [
                'type' => 'file',
                'src'  => $fileSrc,
            ];

            return [
                'has_video' => true,
                'source'    => $source,
                'path'      => $path,
                'url'       => $url,
                'poster'    => $poster,
            ];
        }

        if ($url !== '') {
            $source = static::resolveVideoSource($url, $poster ?: null);

            return [
                'has_video' => $source !== null,
                'source'    => $source,
                'path'      => null,
                'url'       => $url,
                'poster'    => $poster,
            ];
        }

        return [
            'has_video' => false,
            'source'    => null,
            'path'      => null,
            'url'       => '',
            'poster'    => $poster,
        ];
    }

    public static function stepsVideo(): array
    {
        if (! static::tableReady()) {
            return static::buildStepsVideoPayload(static::defaults());
        }

        return Cache::remember('site_setting_steps_video', 3600, function () {
            $values = [];
            foreach (static::stepsVideoKeys() as $key) {
                $values[$key] = static::where('key', $key)->value('value') ?? '';
            }

            return static::buildStepsVideoPayload($values);
        });
    }

    public static function clearStepsVideoCache(): void
    {
        Cache::forget('site_setting_steps_video');
        foreach (static::stepsVideoKeys() as $key) {
            Cache::forget("site_setting_{$key}");
        }
    }
}
