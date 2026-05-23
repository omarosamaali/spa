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
            // ── الليزر (خدمات فرعية) ──
            ['name' => 'ليزر الوجه', 'icon' => '✨', 'description' => 'إزالة شعر الوجه بتقنية ليزر آمنة', 'price' => 80, 'duration_minutes' => 30, 'category' => 'laser', 'sort_order' => 1],
            ['name' => 'ليزر الإبط', 'icon' => '✨', 'description' => 'جلسة ليزر منطقة الإبط', 'price' => 60, 'duration_minutes' => 20, 'category' => 'laser', 'sort_order' => 2],
            ['name' => 'ليزر الساقين', 'icon' => '✨', 'description' => 'إزالة شعر الساقين بالكامل', 'price' => 120, 'duration_minutes' => 45, 'category' => 'laser', 'sort_order' => 3],
            ['name' => 'ليزر كامل الجسم', 'icon' => '✨', 'description' => 'باقة ليزر شاملة لكامل الجسم', 'price' => 250, 'duration_minutes' => 90, 'category' => 'laser', 'sort_order' => 4],

            // ── البوتوكس والفيلر (خدمات فرعية) ──
            ['name' => 'فيلر الشفاه', 'icon' => '💉', 'description' => 'تنعيم ونفخ الشفاه بشكل طبيعي', 'price' => 200, 'duration_minutes' => 30, 'category' => 'botox', 'sort_order' => 10],
            ['name' => 'فيلر الخدود', 'icon' => '💉', 'description' => 'إبراز الخدود وملء التجاعيد', 'price' => 250, 'duration_minutes' => 35, 'category' => 'botox', 'sort_order' => 11],
            ['name' => 'بوتوكس الجبهة', 'icon' => '💉', 'description' => 'تخفيف خطوط الجبهة والتجاعيد', 'price' => 180, 'duration_minutes' => 20, 'category' => 'botox', 'sort_order' => 12],
            ['name' => 'بوتوكس حول العين', 'icon' => '💉', 'description' => 'علاج خطوط العين ورمش العين', 'price' => 160, 'duration_minutes' => 20, 'category' => 'botox', 'sort_order' => 13],

            // ── أقسام أخرى ──
            ['name' => 'تنظيف البشرة العميق', 'icon' => '🌸', 'description' => 'جلسة تنظيف ونضارة وتثبيت البشرة', 'price' => 120, 'duration_minutes' => 60, 'category' => 'skin', 'sort_order' => 20],
            ['name' => 'تقشير وتفتيح', 'icon' => '🌸', 'description' => 'تقشير لطيف لإشراق البشرة', 'price' => 100, 'duration_minutes' => 45, 'category' => 'skin', 'sort_order' => 21],
            ['name' => 'مساج استرخاء', 'icon' => '💆', 'description' => 'استرخاء تام وتجديد الحيوية', 'price' => 100, 'duration_minutes' => 60, 'category' => 'massage', 'sort_order' => 30],
            ['name' => 'مساج الأحجار الساخنة', 'icon' => '💆', 'description' => 'جلسة مساج علاجية بالأحجار', 'price' => 130, 'duration_minutes' => 75, 'category' => 'massage', 'sort_order' => 31],
            ['name' => 'مانيكير', 'icon' => '💅', 'description' => 'عناية وتجميل الأظافر', 'price' => 50, 'duration_minutes' => 40, 'category' => 'nails', 'sort_order' => 40],
            ['name' => 'باديكير', 'icon' => '💅', 'description' => 'عناية أظافر القدمين', 'price' => 60, 'duration_minutes' => 45, 'category' => 'nails', 'sort_order' => 41],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name'], 'category' => $service['category']],
                $service
            );
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
