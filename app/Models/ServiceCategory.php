<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ServiceCategory extends Model
{
    protected $fillable = ['slug', 'label', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** @return array<string, string> */
    public static function defaultCategories(): array
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

    public static function tableReady(): bool
    {
        try {
            return Schema::hasTable('service_categories');
        } catch (\Throwable) {
            return false;
        }
    }

    public static function seedDefaultsIfEmpty(): void
    {
        if (! static::tableReady() || static::query()->exists()) {
            return;
        }

        $order = 0;
        foreach (static::defaultCategories() as $slug => $label) {
            static::create([
                'slug'        => $slug,
                'label'       => $label,
                'sort_order'  => $order++,
                'is_active'   => true,
            ]);
        }

        static::clearCache();
    }

    /** @return array<string, string> slug => label */
    public static function labelsMap(bool $activeOnly = false): array
    {
        if (! static::tableReady()) {
            return static::defaultCategories();
        }

        static::seedDefaultsIfEmpty();

        $cacheKey = $activeOnly ? 'service_categories_active' : 'service_categories_all';

        return Cache::remember($cacheKey, 3600, function () use ($activeOnly) {
            $query = static::query()->orderBy('sort_order')->orderBy('id');
            if ($activeOnly) {
                $query->where('is_active', true);
            }

            $map = [];
            foreach ($query->get() as $cat) {
                $map[$cat->slug] = $cat->label;
            }

            return $map !== [] ? $map : static::defaultCategories();
        });
    }

    public static function labelFor(?string $slug): string
    {
        if (! $slug) {
            return 'بدون تصنيف';
        }

        $map = static::labelsMap(false);

        return $map[$slug] ?? $slug;
    }

    public static function clearCache(): void
    {
        Cache::forget('service_categories_active');
        Cache::forget('service_categories_all');
    }

    public static function makeUniqueSlug(string $base): string
    {
        $slug = Str::slug($base, '_');
        if ($slug === '') {
            $slug = 'cat_'.Str::lower(Str::random(6));
        }

        $original = $slug;
        $n = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $original.'_'.$n++;
        }

        return $slug;
    }

    public function servicesCount(): int
    {
        return Service::where('category', $this->slug)->count();
    }
}
