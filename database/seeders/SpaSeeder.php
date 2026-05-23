<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class SpaSeeder extends Seeder
{
    public function run(): void
    {
        $devices = [
            ['name' => 'جهاز ليزر ١', 'category' => 'laser', 'capacity' => 1, 'sort_order' => 1],
            ['name' => 'جهاز ليزر ٢', 'category' => 'laser', 'capacity' => 1, 'sort_order' => 2],
            ['name' => 'غرفة العلاجات (بشرة/فيلر)', 'category' => 'skin', 'capacity' => 2, 'sort_order' => 10],
            ['name' => 'غرفة المساج', 'category' => 'massage', 'capacity' => 1, 'sort_order' => 20],
            ['name' => 'طاولة الأظافر', 'category' => 'nails', 'capacity' => 2, 'sort_order' => 30],
        ];

        foreach ($devices as $device) {
            Equipment::updateOrCreate(
                ['name' => $device['name']],
                array_merge($device, ['is_active' => true])
            );
        }

        $laserDevice1 = Equipment::where('name', 'جهاز ليزر ١')->value('id');
        $skinRoom = Equipment::where('name', 'غرفة العلاجات (بشرة/فيلر)')->value('id');
        $massageRoom = Equipment::where('name', 'غرفة المساج')->value('id');
        $nailsTable = Equipment::where('name', 'طاولة الأظافر')->value('id');

        $services = [
            // ── الليزر (خدمات فرعية) ──
            ['name' => 'ليزر الوجه', 'icon' => '✨', 'description' => 'إزالة شعر الوجه بتقنية ليزر آمنة', 'price' => 80, 'duration_minutes' => 30, 'category' => 'laser', 'equipment_id' => $laserDevice1, 'sort_order' => 1],
            ['name' => 'ليزر الإبط', 'icon' => '✨', 'description' => 'جلسة ليزر منطقة الإبط', 'price' => 60, 'duration_minutes' => 20, 'category' => 'laser', 'equipment_id' => $laserDevice1, 'sort_order' => 2],
            ['name' => 'ليزر الساقين', 'icon' => '✨', 'description' => 'إزالة شعر الساقين بالكامل', 'price' => 120, 'duration_minutes' => 45, 'category' => 'laser', 'equipment_id' => $laserDevice1, 'sort_order' => 3],
            ['name' => 'ليزر كامل الجسم', 'icon' => '✨', 'description' => 'باقة ليزر شاملة لكامل الجسم', 'price' => 250, 'duration_minutes' => 90, 'category' => 'laser', 'equipment_id' => $laserDevice1, 'sort_order' => 4],

            // ── البوتوكس والفيلر (خدمات فرعية) ──
            ['name' => 'فيلر الشفاه', 'icon' => '💉', 'description' => 'تنعيم ونفخ الشفاه بشكل طبيعي', 'price' => 200, 'duration_minutes' => 30, 'category' => 'botox', 'equipment_id' => $skinRoom, 'sort_order' => 10],
            ['name' => 'فيلر الخدود', 'icon' => '💉', 'description' => 'إبراز الخدود وملء التجاعيد', 'price' => 250, 'duration_minutes' => 35, 'category' => 'botox', 'equipment_id' => $skinRoom, 'sort_order' => 11],
            ['name' => 'بوتوكس الجبهة', 'icon' => '💉', 'description' => 'تخفيف خطوط الجبهة والتجاعيد', 'price' => 180, 'duration_minutes' => 20, 'category' => 'botox', 'equipment_id' => $skinRoom, 'sort_order' => 12],
            ['name' => 'بوتوكس حول العين', 'icon' => '💉', 'description' => 'علاج خطوط العين ورمش العين', 'price' => 160, 'duration_minutes' => 20, 'category' => 'botox', 'equipment_id' => $skinRoom, 'sort_order' => 13],

            // ── أقسام أخرى ──
            ['name' => 'تنظيف البشرة العميق', 'icon' => '🌸', 'description' => 'جلسة تنظيف ونضارة وتثبيت البشرة', 'price' => 120, 'duration_minutes' => 60, 'category' => 'skin', 'equipment_id' => $skinRoom, 'sort_order' => 20],
            ['name' => 'تقشير وتفتيح', 'icon' => '🌸', 'description' => 'تقشير لطيف لإشراق البشرة', 'price' => 100, 'duration_minutes' => 45, 'category' => 'skin', 'equipment_id' => $skinRoom, 'sort_order' => 21],
            ['name' => 'مساج استرخاء', 'icon' => '💆', 'description' => 'استرخاء تام وتجديد الحيوية', 'price' => 100, 'duration_minutes' => 60, 'category' => 'massage', 'equipment_id' => $massageRoom, 'sort_order' => 30],
            ['name' => 'مساج الأحجار الساخنة', 'icon' => '💆', 'description' => 'جلسة مساج علاجية بالأحجار', 'price' => 130, 'duration_minutes' => 75, 'category' => 'massage', 'equipment_id' => $massageRoom, 'sort_order' => 31],
            ['name' => 'مانيكير', 'icon' => '💅', 'description' => 'عناية وتجميل الأظافر', 'price' => 50, 'duration_minutes' => 40, 'category' => 'nails', 'equipment_id' => $nailsTable, 'sort_order' => 40],
            ['name' => 'باديكير', 'icon' => '💅', 'description' => 'عناية أظافر القدمين', 'price' => 60, 'duration_minutes' => 45, 'category' => 'nails', 'equipment_id' => $nailsTable, 'sort_order' => 41],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name'], 'category' => $service['category']],
                array_merge($service, ['is_active' => true])
            );
        }

        // إيقاف الصفوف القديمة (قسم واحد = خدمة واحدة بسعر) — السعر يكون للخدمات الفرعية فقط
        foreach (Service::legacyParentNames() as $legacyName) {
            Service::where('name', $legacyName)->update(['is_active' => false]);
        }

        $staffMembers = [
            ['name' => 'د. سارة أحمد', 'role' => 'أخصائية الليزر والبشرة', 'is_active' => true],
            ['name' => 'نور الهدى', 'role' => 'أخصائية الأظافر والمكياج', 'is_active' => true],
            ['name' => 'رنا محمد', 'role' => 'أخصائية المساج والعلاجات', 'is_active' => true],
        ];

        $sara = Staff::firstOrCreate(['name' => 'د. سارة أحمد'], $staffMembers[0]);
        $noor = Staff::firstOrCreate(['name' => 'نور الهدى'], $staffMembers[1]);
        $rana = Staff::firstOrCreate(['name' => 'رنا محمد'], $staffMembers[2]);

        $laserIds = Service::where('category', 'laser')->where('is_active', true)->pluck('id');
        $skinBotoxIds = Service::whereIn('category', ['skin', 'botox'])->where('is_active', true)->pluck('id');
        $massageIds = Service::where('category', 'massage')->where('is_active', true)->pluck('id');
        $nailsIds = Service::where('category', 'nails')->where('is_active', true)->pluck('id');

        $sara->services()->sync($laserIds->merge($skinBotoxIds));
        $noor->services()->sync($nailsIds);
        $rana->services()->sync($massageIds);

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
