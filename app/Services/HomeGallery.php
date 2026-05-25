<?php

namespace App\Services;

use App\Models\HomeGalleryItem;
use App\Models\SiteSetting;
use Illuminate\Support\Collection;

class HomeGallery
{
    public const SETTING_ENABLED = 'home_gallery_enabled';

    public const SETTING_BADGE = 'home_gallery_badge';

    public const SETTING_TITLE = 'home_gallery_title';

    /** @return array{enabled: bool, badge: string, title: string, items: Collection<int, HomeGalleryItem>|Collection<int, object>} */
    public static function forHomepage(): array
    {
        $enabled = SiteSetting::get(self::SETTING_ENABLED, '1') === '1';
        $badge = trim(SiteSetting::get(self::SETTING_BADGE, 'معرضنا')) ?: 'معرضنا';
        $title = trim(SiteSetting::get(self::SETTING_TITLE, 'لحظات من العناية')) ?: 'لحظات من العناية';

        $items = HomeGalleryItem::active()->get();

        return [
            'enabled' => $enabled,
            'badge'   => $badge,
            'title'   => $title,
            'items'   => $items,
            'placeholders' => collect(HomeGalleryItem::defaultPlaceholders()),
        ];
    }

    public static function saveSection(bool $enabled, string $badge, string $title): void
    {
        SiteSetting::set(self::SETTING_ENABLED, $enabled ? '1' : '0');
        SiteSetting::set(self::SETTING_BADGE, $badge);
        SiteSetting::set(self::SETTING_TITLE, $title);
    }
}
