<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlidesSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'sort_order' => 1,
                'type' => 'video',
                'media_url' => 'https://videos.pexels.com/video-files/3209828/3209828-hd_1920_1080_25fps.mp4',
                'media_url_alt' => 'https://videos.pexels.com/video-files/3214436/3214436-hd_1920_1080_25fps.mp4',
                'poster_url' => 'https://images.unsplash.com/photo-1583416750470-965b2707b355?w=1920&q=60&auto=format&fit=crop',
                'badge' => 'تجربة NAY SPA الفعلية',
                'title' => 'اكتشفي',
                'title_highlight' => 'عالم الفخامة',
                'subtitle' => 'تجربة سبا فاخرة في أجواء هادئة ومريحة',
                'btn_primary_text' => 'احجزي موعدك الآن',
                'btn_primary_url' => '/booking',
                'btn_secondary_text' => 'تواصل معنا',
                'btn_secondary_url' => 'https://wa.me/9647701234567',
            ],
            [
                'sort_order' => 2,
                'type' => 'image',
                'media_url' => 'https://images.unsplash.com/photo-1583416750470-965b2707b355?w=1920&q=80&auto=format&fit=crop',
                'badge' => 'أحدث تقنيات • أفضل تجربة',
                'title' => 'جمالك',
                'title_highlight' => 'يبدأ هنا',
                'subtitle' => 'منصة حجز ذكية لجميع خدمات التجميل والعناية',
                'btn_primary_text' => 'احجزي الآن',
                'btn_primary_url' => '/booking',
                'btn_secondary_text' => 'جميع الخدمات',
                'btn_secondary_url' => '/services',
            ],
            [
                'sort_order' => 3,
                'type' => 'image',
                'media_url' => 'https://images.unsplash.com/photo-1508380702597-707c1b00695c?w=1920&q=80&auto=format&fit=crop',
                'badge' => 'استرخاء تام • تجديد الحيوية',
                'title' => 'جلسات',
                'title_highlight' => 'تُجدد طاقتك',
                'subtitle' => 'جلسات علاجية وترفيهية لتجديد الطاقة والراحة التامة',
                'btn_primary_text' => 'احجزي الآن',
                'btn_primary_url' => '/booking',
                'btn_secondary_text' => 'جميع الخدمات',
                'btn_secondary_url' => '/services',
            ],
            [
                'sort_order' => 4,
                'type' => 'image',
                'media_url' => 'https://images.unsplash.com/photo-1556760544-74068565f05c?w=1920&q=80&auto=format&fit=crop',
                'badge' => 'منتجات فاخرة • نتائج مذهلة',
                'title' => 'منتجات',
                'title_highlight' => 'تُعنى بك',
                'subtitle' => 'أفضل منتجات العناية العالمية لنتائج مضمونة',
                'btn_primary_text' => 'احجزي الآن',
                'btn_primary_url' => '/booking',
                'btn_secondary_text' => 'تواصلي معنا',
                'btn_secondary_url' => '/contact',
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::firstOrCreate(
                ['sort_order' => $slide['sort_order']],
                $slide
            );
        }
    }
}
