<?php

namespace App\Models;

class SiteTheme
{
    /**
     * 10 pre-defined spa themes inspired by luxury spa branding.
     * Each theme fully overrides the CSS custom-property set.
     */
    public static function presets(): array
    {
        return [

            // ── 1 ─────────────────────────────────────────────────────────────
            'luxea' => [
                'id'             => 'luxea',
                'name'           => 'LUXÉA',
                'tagline'        => 'جمالك يستحق العناية',
                'description'    => 'أناقة كلاسيكية بورديّة ذهبية دافئة',
                'dark_mode'      => true,
                'hero_layout'    => 'classic',
                'primary'        => '#e8b4b8',
                'primary_dark'   => '#c9888e',
                'primary_light'  => '#f5dfe1',
                'gold'           => '#c9a96e',
                'dark'           => '#1a1a1a',
                'dark_2'         => '#2a2a2a',
                'dark_3'         => '#131313',
                'text_body'      => '#e8e0dd',
                'hero_gradient'  => 'linear-gradient(135deg,rgba(18,8,14,0.88) 0%,rgba(18,8,14,0.42) 55%,rgba(40,18,28,0.75) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#1a1a1a 0%,#2a2a2a 40%,#3d2b2e 100%)',
                'preview_colors' => ['#e8b4b8', '#c9888e', '#c9a96e', '#1a1a1a'],
            ],

            // ── 2 ─────────────────────────────────────────────────────────────
            'aurora' => [
                'id'             => 'aurora',
                'name'           => 'AURORA',
                'tagline'        => 'جمالك... سطور من الأناقة',
                'description'    => 'غموض بنفسجي ساحر بخلفية ليلية',
                'dark_mode'      => true,
                'hero_layout'    => 'centered',
                'primary'        => '#a78bfa',
                'primary_dark'   => '#7c3aed',
                'primary_light'  => '#ddd6fe',
                'gold'           => '#c084fc',
                'dark'           => '#0f0a1e',
                'dark_2'         => '#1e1340',
                'dark_3'         => '#0a0714',
                'text_body'      => '#e2d9f3',
                'hero_gradient'  => 'linear-gradient(135deg,rgba(15,10,30,0.9) 0%,rgba(60,20,100,0.5) 55%,rgba(124,58,237,0.3) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#0f0a1e 0%,#1e1340 40%,#2d1b69 100%)',
                'preview_colors' => ['#a78bfa', '#7c3aed', '#c084fc', '#0f0a1e'],
            ],

            // ── 3 ─────────────────────────────────────────────────────────────
            'nirvana' => [
                'id'             => 'nirvana',
                'name'           => 'NIRVANA',
                'tagline'        => 'ملاذك للاسترخاء والتجديد',
                'description'    => 'هدوء كريمي فاتح بألوان الطبيعة',
                'dark_mode'      => false,
                'hero_layout'    => 'minimal',
                'primary'        => '#b5977a',
                'primary_dark'   => '#8b6856',
                'primary_light'  => '#e8d5c4',
                'gold'           => '#8b6856',
                'dark'           => '#f5f0e8',
                'dark_2'         => '#ede5d8',
                'dark_3'         => '#faf7f2',
                'text_body'      => '#4a3728',
                'hero_gradient'  => 'linear-gradient(160deg,rgba(74,55,40,0.82) 0%,rgba(139,104,86,0.5) 60%,rgba(232,213,196,0.12) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#4a3728 0%,#6b4f3a 40%,#8b6856 100%)',
                'preview_colors' => ['#b5977a', '#8b6856', '#e8d5c4', '#4a3728'],
            ],

            // ── 4 ─────────────────────────────────────────────────────────────
            'vera' => [
                'id'             => 'vera',
                'name'           => 'VERA',
                'tagline'        => 'شعور جديد بجمال طبيعي',
                'description'    => 'خضرة طبيعية عميقة وهادئة',
                'dark_mode'      => true,
                'hero_layout'    => 'nature',
                'primary'        => '#6ee7b7',
                'primary_dark'   => '#059669',
                'primary_light'  => '#d1fae5',
                'gold'           => '#fbbf24',
                'dark'           => '#0d2b1e',
                'dark_2'         => '#1a3d2b',
                'dark_3'         => '#071a12',
                'text_body'      => '#d1fae5',
                'hero_gradient'  => 'linear-gradient(135deg,rgba(7,26,18,0.95) 0%,rgba(5,150,105,0.3) 65%,rgba(16,78,42,0.6) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#0d2b1e 0%,#1a3d2b 40%,#2d6a4f 100%)',
                'preview_colors' => ['#6ee7b7', '#059669', '#fbbf24', '#0d2b1e'],
            ],

            // ── 5 ─────────────────────────────────────────────────────────────
            'elira' => [
                'id'             => 'elira',
                'name'           => 'ELIRA',
                'tagline'        => 'نعومة تدوم وجمال يبرزك',
                'description'    => 'لافندر راقٍ بلمسة أنثوية رقيقة',
                'dark_mode'      => true,
                'hero_layout'    => 'editorial',
                'primary'        => '#d8b4fe',
                'primary_dark'   => '#9333ea',
                'primary_light'  => '#f3e8ff',
                'gold'           => '#f0abfc',
                'dark'           => '#1e1028',
                'dark_2'         => '#2d1b3d',
                'dark_3'         => '#130a1c',
                'text_body'      => '#f3e8ff',
                'hero_gradient'  => 'linear-gradient(135deg,rgba(19,10,28,0.96) 0%,rgba(147,51,234,0.25) 55%,rgba(60,20,80,0.7) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#1e1028 0%,#2d1b3d 40%,#4a2060 100%)',
                'preview_colors' => ['#d8b4fe', '#9333ea', '#f0abfc', '#1e1028'],
            ],

            // ── 6 ─────────────────────────────────────────────────────────────
            'solea' => [
                'id'             => 'solea',
                'name'           => 'SOLÉA',
                'tagline'        => 'تألقي كل يوم بأفضل نسخة منك',
                'description'    => 'دفء رملي ذهبي بأجواء صحراوية فاخرة',
                'dark_mode'      => false,
                'hero_layout'    => 'minimal',
                'primary'        => '#d4a574',
                'primary_dark'   => '#a0704e',
                'primary_light'  => '#f3e3d0',
                'gold'           => '#c9892e',
                'dark'           => '#2e1a08',
                'dark_2'         => '#3d2510',
                'dark_3'         => '#1e1005',
                'text_body'      => '#faf3ea',
                'hero_gradient'  => 'linear-gradient(160deg,rgba(30,16,5,0.9) 0%,rgba(160,112,78,0.4) 55%,rgba(100,60,30,0.65) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#2e1a08 0%,#4a2e18 40%,#a0704e 100%)',
                'preview_colors' => ['#d4a574', '#a0704e', '#c9892e', '#2e1a08'],
            ],

            // ── 7 ─────────────────────────────────────────────────────────────
            'bella_rose' => [
                'id'             => 'bella_rose',
                'name'           => 'BELLA ROSE',
                'tagline'        => 'جمالك قصة تكتبينها معنا',
                'description'    => 'وردي زاهٍ أنثوي نابض بالحيوية',
                'dark_mode'      => true,
                'hero_layout'    => 'bold',
                'primary'        => '#f9a8d4',
                'primary_dark'   => '#db2777',
                'primary_light'  => '#fce7f3',
                'gold'           => '#f472b6',
                'dark'           => '#1a0a12',
                'dark_2'         => '#2d1020',
                'dark_3'         => '#100610',
                'text_body'      => '#fce7f3',
                'hero_gradient'  => 'linear-gradient(135deg,rgba(16,6,16,0.94) 0%,rgba(219,39,119,0.28) 55%,rgba(80,10,50,0.75) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#1a0a12 0%,#2d1020 40%,#6d1a3e 100%)',
                'preview_colors' => ['#f9a8d4', '#db2777', '#f472b6', '#1a0a12'],
            ],

            // ── 8 ─────────────────────────────────────────────────────────────
            'azure' => [
                'id'             => 'azure',
                'name'           => 'AZURÉ',
                'tagline'        => 'صفاء الذهن ونقاء الجسد',
                'description'    => 'نقاء مائي فاتح بأجواء محيطية هادئة',
                'dark_mode'      => false,
                'hero_layout'    => 'minimal',
                'primary'        => '#22d3ee',
                'primary_dark'   => '#0891b2',
                'primary_light'  => '#cffafe',
                'gold'           => '#06b6d4',
                'dark'           => '#082f3e',
                'dark_2'         => '#0e4a60',
                'dark_3'         => '#041e28',
                'text_body'      => '#e0f9ff',
                'hero_gradient'  => 'linear-gradient(160deg,rgba(4,30,40,0.92) 0%,rgba(8,145,178,0.3) 60%,rgba(6,182,212,0.25) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#082f3e 0%,#0e4a60 40%,#0891b2 100%)',
                'preview_colors' => ['#22d3ee', '#0891b2', '#cffafe', '#082f3e'],
            ],

            // ── 9 ─────────────────────────────────────────────────────────────
            'maison_dor' => [
                'id'             => 'maison_dor',
                'name'           => "MAISON D'OR",
                'tagline'        => 'الفخامة عنوان تفاصيلك',
                'description'    => 'ذهبي فاخر بلمسة ملكية أوروبية',
                'dark_mode'      => true,
                'hero_layout'    => 'editorial',
                'primary'        => '#fbbf24',
                'primary_dark'   => '#d97706',
                'primary_light'  => '#fef3c7',
                'gold'           => '#f59e0b',
                'dark'           => '#1a1408',
                'dark_2'         => '#2a2010',
                'dark_3'         => '#0f0d04',
                'text_body'      => '#fef3c7',
                'hero_gradient'  => 'linear-gradient(135deg,rgba(15,13,4,0.94) 0%,rgba(217,119,6,0.3) 55%,rgba(100,60,10,0.75) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#1a1408 0%,#2a2010 40%,#78450a 100%)',
                'preview_colors' => ['#fbbf24', '#d97706', '#f59e0b', '#1a1408'],
            ],

            // ── 10 ────────────────────────────────────────────────────────────
            'pureli' => [
                'id'             => 'pureli',
                'name'           => 'PURELI',
                'tagline'        => 'طبيعة نقية وجمال أصيل',
                'description'    => 'نضارة خضراء طبيعية بملامح نباتية',
                'dark_mode'      => true,
                'hero_layout'    => 'nature',
                'primary'        => '#86efac',
                'primary_dark'   => '#16a34a',
                'primary_light'  => '#dcfce7',
                'gold'           => '#4ade80',
                'dark'           => '#0a1f12',
                'dark_2'         => '#14301e',
                'dark_3'         => '#06120b',
                'text_body'      => '#dcfce7',
                'hero_gradient'  => 'linear-gradient(135deg,rgba(6,18,11,0.95) 0%,rgba(22,163,74,0.25) 55%,rgba(20,60,30,0.7) 100%)',
                'nav_gradient'   => 'linear-gradient(135deg,#0a1f12 0%,#14301e 40%,#166534 100%)',
                'preview_colors' => ['#86efac', '#16a34a', '#4ade80', '#0a1f12'],
            ],
        ];
    }

    public static function getById(string $id): array
    {
        return static::presets()[$id] ?? static::presets()['luxea'];
    }

    public static function exists(string $id): bool
    {
        return isset(static::presets()[$id]);
    }

    /**
     * Merge a preset with custom overrides stored in DB (logo, name, tagline, manual colors).
     * Manual color overrides take precedence over the preset only when they were explicitly saved.
     */
    public static function mergeWithCustom(array $preset, array $overrides): array
    {
        $result = $preset;

        foreach (['primary', 'primary_dark', 'primary_light', 'gold', 'dark', 'dark_2'] as $k) {
            $settingKey = 'theme_' . $k;
            if (! empty($overrides[$settingKey])) {
                $map = [
                    'theme_primary'       => 'primary',
                    'theme_primary_dark'  => 'primary_dark',
                    'theme_primary_light' => 'primary_light',
                    'theme_gold'          => 'gold',
                    'theme_dark'          => 'dark',
                    'theme_dark_2'        => 'dark_2',
                ];
                if (isset($map[$settingKey])) {
                    $result[$map[$settingKey]] = $overrides[$settingKey];
                }
            }
        }

        if (! empty($overrides['site_name']))    $result['site_name']    = $overrides['site_name'];
        if (! empty($overrides['site_tagline'])) $result['tagline']      = $overrides['site_tagline'];
        if (! empty($overrides['logo_path']))    $result['logo_path']    = $overrides['logo_path'];
        if (! empty($overrides['favicon_path'])) $result['favicon_path'] = $overrides['favicon_path'];

        return $result;
    }

    /**
     * Build the full theme payload that AppServiceProvider shares as $siteTheme.
     */
    public static function buildPayload(array $merged): array
    {
        $logoPath    = $merged['logo_path'] ?? '';
        $faviconPath = $merged['favicon_path'] ?? '';

        $tagline = $merged['tagline'] ?? $merged['site_tagline'] ?? '';

        return [
            'id'               => $merged['id'],
            'name'             => $merged['name'],
            'tagline'          => $tagline,
            'site_tagline'     => $tagline,
            'dark_mode'        => $merged['dark_mode'] ?? true,
            'hero_layout'      => $merged['hero_layout'] ?? 'classic',
            'primary'          => $merged['primary'],
            'primary_dark'     => $merged['primary_dark'],
            'primary_light'    => $merged['primary_light'],
            'gold'             => $merged['gold'],
            'dark'             => $merged['dark'],
            'dark_2'           => $merged['dark_2'],
            'dark_3'           => $merged['dark_3'] ?? $merged['dark'],
            'text_body'        => $merged['text_body'] ?? '#e8e0dd',
            'hero_gradient'    => $merged['hero_gradient'] ?? '',
            'nav_gradient'     => $merged['nav_gradient'] ?? '',
            'preview_colors'   => $merged['preview_colors'] ?? [$merged['primary']],
            'site_name'        => $merged['site_name'] ?? 'NAY SPA',
            'logo_url'         => SiteSetting::assetUrl($logoPath),
            'favicon_url'      => SiteSetting::assetUrl($faviconPath),
            'has_logo'         => (bool) SiteSetting::assetUrl($logoPath),
            'has_favicon'      => (bool) SiteSetting::assetUrl($faviconPath),
        ];
    }
}
