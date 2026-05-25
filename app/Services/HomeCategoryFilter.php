<?php

namespace App\Services;

use App\Models\Service;
use App\Models\SiteSetting;

class HomeCategoryFilter
{
    public const SETTING_SHOW_ALL = 'home_filter_show_all';

    public const SETTING_DEFAULT = 'home_filter_default';

    public const SETTING_CATEGORIES = 'home_filter_categories';

    /** @return array{show_all: bool, default: string, visible: array<string, bool>, tabs: list<array{key: string, label: string}>} */
    public static function config(): array
    {
        $labels = Service::categoryLabelsForAdmin();
        $visible = static::defaultVisibility();

        $stored = SiteSetting::get(self::SETTING_CATEGORIES, '');
        if ($stored !== '') {
            $decoded = json_decode($stored, true);
            if (is_array($decoded)) {
                foreach ($labels as $key => $_label) {
                    $visible[$key] = ! empty($decoded[$key]);
                }
            }
        }

        $showAll = SiteSetting::get(self::SETTING_SHOW_ALL, '1') === '1';
        $default = SiteSetting::get(self::SETTING_DEFAULT, 'all');

        $tabs = [];
        if ($showAll) {
            $tabs[] = ['key' => 'all', 'label' => 'الكل'];
        }
        $activeLabels = Service::categoryLabels();
        foreach ($activeLabels as $key => $label) {
            if ($visible[$key] ?? false) {
                $tabs[] = ['key' => $key, 'label' => $label];
            }
        }

        $validKeys = array_column($tabs, 'key');
        if ($validKeys === [] || ! in_array($default, $validKeys, true)) {
            $default = $validKeys[0] ?? 'all';
        }

        return [
            'show_all' => $showAll,
            'default'  => $default,
            'visible'  => $visible,
            'tabs'     => $tabs,
        ];
    }

    /** @return array<string, bool> */
    public static function defaultVisibility(): array
    {
        $visible = [];
        foreach (Service::categoryLabelsForAdmin() as $key => $_label) {
            $visible[$key] = true;
        }

        return $visible;
    }

    public static function save(bool $showAll, string $default, array $visibleFlags): void
    {
        SiteSetting::set(self::SETTING_SHOW_ALL, $showAll ? '1' : '0');
        SiteSetting::set(self::SETTING_DEFAULT, $default);

        $normalized = [];
        foreach (Service::categoryLabelsForAdmin() as $key => $_label) {
            $normalized[$key] = ! empty($visibleFlags[$key]);
        }

        SiteSetting::set(self::SETTING_CATEGORIES, json_encode($normalized, JSON_UNESCAPED_UNICODE));
    }
}
