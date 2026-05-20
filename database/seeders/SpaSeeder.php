<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Staff;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class SpaSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'الليزر', 'icon' => '✨', 'description' => 'إزالة الشعر بتقنيات حديثة آمنة وفعالة', 'price' => 150, 'duration_minutes' => 45, 'category' => 'laser', 'sort_order' => 1],
            ['name' => 'البشرة', 'icon' => '🌸', 'description' => 'جلسات تنظيف ونضارة وتثبيت البشرة', 'price' => 120, 'duration_minutes' => 60, 'category' => 'skin', 'sort_order' => 2],
            ['name' => 'البوتوكس والفيلر', 'icon' => '💉', 'description' => 'إبراز جمالك بشكل طبيعي وآمن', 'price' => 300, 'duration_minutes' => 30, 'category' => 'botox', 'sort_order' => 3],
            ['name' => 'المساج', 'icon' => '💆', 'description' => 'استرخاء تام وتجديد الحيوية', 'price' => 100, 'duration_minutes' => 60, 'category' => 'massage', 'sort_order' => 4],
            ['name' => 'الأظافر', 'icon' => '💅', 'description' => 'تصميم الأظافر بأحدث الستايلات', 'price' => 80, 'duration_minutes' => 45, 'category' => 'nails', 'sort_order' => 5],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['name' => $service['name']], $service);
        }

        $staffMembers = [
            ['name' => 'د. سارة أحمد', 'role' => 'أخصائية الليزر والبشرة', 'is_active' => true],
            ['name' => 'نور الهدى', 'role' => 'أخصائية الأظافر والمكياج', 'is_active' => true],
            ['name' => 'رنا محمد', 'role' => 'أخصائية المساج والعلاجات', 'is_active' => true],
        ];

        foreach ($staffMembers as $member) {
            Staff::firstOrCreate(['name' => $member['name']], $member);
        }

        $testimonials = [
            ['client_name' => 'سارة', 'client_city' => 'بغداد', 'content' => 'أفضل تجربة ليزر، المكان نظيف والعاملات راقيات جداً', 'rating' => 5],
            ['client_name' => 'نور', 'client_city' => 'النجف', 'content' => 'جلسات البشرة غيّرت بشرتي ١٨٠ درجة، أنصح الجميع', 'rating' => 5],
            ['client_name' => 'رنا', 'client_city' => 'البصرة', 'content' => 'خدمة ممتازة ونتائج رائعة، سأعود دائماً', 'rating' => 5],
        ];

        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['client_name' => $t['client_name'], 'client_city' => $t['client_city']], $t);
        }
    }
}
