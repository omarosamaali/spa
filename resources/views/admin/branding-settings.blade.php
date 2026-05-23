@extends('layouts.admin')
@section('title', 'الألوان والشعار')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">الألوان والشعار</h1>
    <p class="text-sm" style="color:#888">تعديل ألوان الموقع بالكامل، اللوجو، والأيقونة (Favicon)</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl font-bold text-sm" style="background:#d1fae5; color:#059669">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('admin.branding-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="brandingForm">
    @csrf
    @method('PUT')

    {{-- معاينة --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="text-lg font-black mb-4" style="color:#1a1a1a">معاينة سريعة</h2>
        <div class="rounded-2xl p-6 flex flex-wrap items-center gap-6" id="themePreview" style="background:var(--spa-dark);">
            <div class="flex items-center gap-3">
                @if($theme['has_logo'])
                <img src="{{ $theme['logo_url'] }}" alt="" id="previewLogo" style="height:48px;width:auto;max-width:120px;object-fit:contain;">
                @else
                <div id="previewLogoFallback" class="w-12 h-12 rounded-xl flex items-center justify-center" style="background:linear-gradient(135deg,var(--spa-primary),var(--spa-primary-dark));">
                    <span class="text-white font-black text-xs">LOGO</span>
                </div>
                @endif
                <div class="text-white">
                    <div class="font-black text-lg" id="previewName">{{ $theme['site_name'] }}</div>
                    <div class="text-sm" id="previewTagline" style="color:var(--spa-primary)">{{ $theme['site_tagline'] ?? $theme['tagline'] ?? '' }}</div>
                </div>
            </div>
            <button type="button" class="btn-primary text-sm">زر تجريبي</button>
            <span class="badge-spa">شارة</span>
        </div>
    </div>

    {{-- اسم الموقع --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">اسم الموقع والشعار النصي</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="form-label">اسم الموقع <span style="color:#dc2626">*</span></label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}"
                       class="form-input" id="inputSiteName">
            </div>
            <div>
                <label class="form-label">الجملة تحت الاسم</label>
                <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}"
                       class="form-input" id="inputSiteTagline" placeholder="جمالك يستحق العناية">
            </div>
        </div>
    </div>

    {{-- الألوان --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">ألوان الموقع</h2>
        <p class="text-sm" style="color:#888">تُطبَّق على الأزرار، الخلفيات، الشارات، والتدرجات في كل الصفحات</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['key'=>'theme_primary', 'label'=>'اللون الرئيسي (وردي)', 'def'=>'#e8b4b8'],
                ['key'=>'theme_primary_dark', 'label'=>'اللون الداكن', 'def'=>'#c9888e'],
                ['key'=>'theme_primary_light', 'label'=>'اللون الفاتح', 'def'=>'#f5dfe1'],
                ['key'=>'theme_gold', 'label'=>'اللون الذهبي', 'def'=>'#c9a96e'],
                ['key'=>'theme_dark', 'label'=>'خلفية الموقع', 'def'=>'#1a1a1a'],
                ['key'=>'theme_dark_2', 'label'=>'خلفية الكروت', 'def'=>'#2a2a2a'],
            ] as $color)
            @php $val = old($color['key'], $settings[$color['key']] ?: $color['def']); @endphp
            <div>
                <label class="form-label">{{ $color['label'] }}</label>
                <div class="flex items-center gap-3">
                    <input type="color" class="color-picker w-12 h-12 rounded-lg border-0 cursor-pointer p-0"
                           data-target="{{ $color['key'] }}" value="{{ $val }}">
                    <input type="text" name="{{ $color['key'] }}" value="{{ $val }}"
                           class="form-input color-text font-mono text-sm" dir="ltr"
                           pattern="^#?[0-9A-Fa-f]{6}$" data-key="{{ $color['key'] }}">
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- اللوجو --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">لوجو الموقع</h2>
        @if($theme['has_logo'])
        <div class="flex items-center gap-4 p-4 rounded-xl" style="background:#f9f9f9;">
            <img src="{{ $theme['logo_url'] }}" alt="Logo" style="max-height:64px;max-width:200px;object-fit:contain;">
            <label class="flex items-center gap-2 text-sm font-bold cursor-pointer" style="color:#dc2626">
                <input type="checkbox" name="remove_logo" value="1"> حذف اللوجو الحالي
            </label>
        </div>
        @endif
        <div>
            <label class="form-label">رفع لوجو جديد</label>
            <input type="file" name="logo_file" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                   class="form-input" style="padding:0.5rem">
            <p class="text-xs mt-1" style="color:#888">PNG / JPG / WebP / SVG — يظهر في الهيدر والفوتر. شفاف يُفضَّل</p>
        </div>
    </div>

    {{-- Favicon --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">أيقونة المتصفح (Favicon)</h2>
        @if($theme['has_favicon'])
        <div class="flex items-center gap-4 p-4 rounded-xl" style="background:#f9f9f9;">
            <img src="{{ $theme['favicon_url'] }}" alt="Favicon" style="width:32px;height:32px;object-fit:contain;">
            <label class="flex items-center gap-2 text-sm font-bold cursor-pointer" style="color:#dc2626">
                <input type="checkbox" name="remove_favicon" value="1"> حذف الأيقونة الحالية
            </label>
        </div>
        @endif
        <div>
            <label class="form-label">رفع Favicon جديد</label>
            <input type="file" name="favicon_file" accept="image/png,image/jpeg,image/x-icon,image/svg+xml,.ico"
                   class="form-input" style="padding:0.5rem">
            <p class="text-xs mt-1" style="color:#888">مربّع 32×32 أو 64×64 — PNG أو ICO</p>
        </div>
    </div>

    <button type="submit" class="btn-primary px-10 py-3 text-base">
        حفظ الألوان والشعار
    </button>
</form>

@endsection

@push('scripts')
<script>
(function () {
    const root = document.documentElement;
    const pickers = document.querySelectorAll('.color-picker');
    const texts = document.querySelectorAll('.color-text');

    const cssMap = {
        theme_primary: '--spa-primary',
        theme_primary_dark: '--spa-primary-dark',
        theme_primary_light: '--spa-primary-light',
        theme_gold: '--spa-gold',
        theme_dark: '--spa-dark',
        theme_dark_2: '--spa-dark-2',
    };

    function norm(hex) {
        hex = (hex || '').trim();
        if (!hex.startsWith('#')) hex = '#' + hex;
        return hex.length === 7 ? hex : hex;
    }

    function applyColor(key, hex) {
        const v = norm(hex);
        const cssVar = cssMap[key];
        if (cssVar) root.style.setProperty(cssVar, v);
        const picker = document.querySelector('.color-picker[data-target="' + key + '"]');
        const text = document.querySelector('.color-text[data-key="' + key + '"]');
        if (picker && /^#[0-9A-Fa-f]{6}$/.test(v)) picker.value = v;
        if (text) text.value = v;
    }

    pickers.forEach(p => {
        p.addEventListener('input', () => applyColor(p.dataset.target, p.value));
    });
    texts.forEach(t => {
        t.addEventListener('input', () => applyColor(t.dataset.key, t.value));
    });

    const nameIn = document.getElementById('inputSiteName');
    const tagIn = document.getElementById('inputSiteTagline');
    const previewName = document.getElementById('previewName');
    const previewTag = document.getElementById('previewTagline');
    if (nameIn && previewName) nameIn.addEventListener('input', () => { previewName.textContent = nameIn.value; });
    if (tagIn && previewTag) tagIn.addEventListener('input', () => { previewTag.textContent = tagIn.value; });
})();
</script>
@endpush
