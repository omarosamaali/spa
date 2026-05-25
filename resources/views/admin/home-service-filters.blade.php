@extends('layouts.admin')
@section('title', 'فلتر الخدمات - الرئيسية')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">فلتر «اختاري ما يناسبك»</h1>
    <p class="text-sm" style="color:#888">
        تحكم في أزرار الأقسام في الصفحة الرئيسية — إظهار «الكل»، الفلتر الافتراضي، وتفعيل كل قسم.
        أسماء الأقسام (ليزر، بشرة…) من <a href="{{ route('admin.service-categories') }}" class="font-bold" style="color:#c9888e">تصنيفات الخدمات</a>.
    </p>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl text-sm font-bold" style="background:#d1fae5; color:#059669;">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-xl text-sm" style="background:#fee2e2; color:#dc2626;">
    <ul class="list-disc pr-5 space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.home-service-filters.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">الإعدادات العامة</h2>

        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="show_all" value="1" class="w-5 h-5 rounded" style="accent-color:#c9888e"
                   {{ old('show_all', $config['show_all'] ? '1' : '0') ? 'checked' : '' }}
                   id="showAllCheckbox">
            <span class="font-bold">إظهار زر «الكل» في الفلتر</span>
        </label>

        <div class="max-w-md">
            <label class="form-label">الفلتر الافتراضي عند فتح الصفحة</label>
            <select name="default" id="defaultFilterSelect" class="form-input">
                @if(old('show_all', $config['show_all']))
                <option value="all" {{ old('default', $config['default']) === 'all' ? 'selected' : '' }}>الكل</option>
                @endif
                @foreach($categoryLabels as $key => $label)
                @php $isOn = old("visible.$key", ($config['visible'][$key] ?? false) ? '1' : ''); @endphp
                <option value="{{ $key }}" data-category="{{ $key }}"
                        class="default-opt-cat"
                        {{ old('default', $config['default']) === $key ? 'selected' : '' }}
                        {{ $isOn ? '' : 'disabled hidden' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
            <p class="text-xs mt-1" style="color:#888">أول زر يظهر نشطاً للزائر — يجب أن يكون من الأقسام المفعّلة أدناه.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="text-lg font-black mb-4" style="color:#1a1a1a">الأقسام الظاهرة في الفلتر</h2>
        <p class="text-sm mb-4" style="color:#888">كل خدمة في «الخدمات» لها قسم — هنا تتحكم أي أقسام تظهر كأزرار للزائر.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($categoryLabels as $key => $label)
            <label class="flex items-center gap-3 p-4 rounded-xl cursor-pointer transition-all"
                   style="border:1px solid #f0e8e9; background:#fdf8f5">
                <input type="checkbox" name="visible[{{ $key }}]" value="1"
                       class="w-5 h-5 rounded category-visible-cb" style="accent-color:#c9888e"
                       data-key="{{ $key }}"
                       {{ old("visible.$key", ($config['visible'][$key] ?? false) ? '1' : '') ? 'checked' : '' }}>
                <span class="font-bold" style="color:#1a1a1a">{{ $label }}</span>
                <span class="text-xs" style="color:#888">({{ $key }})</span>
            </label>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn-primary">حفظ الإعدادات</button>
</form>

@push('scripts')
<script>
(function () {
    const showAll = document.getElementById('showAllCheckbox');
    const defaultSelect = document.getElementById('defaultFilterSelect');
    const categoryCbs = document.querySelectorAll('.category-visible-cb');

    function rebuildDefaultOptions() {
        const current = defaultSelect.value;
        const allOpt = defaultSelect.querySelector('option[value="all"]');
        if (allOpt) {
            allOpt.disabled = !showAll.checked;
            allOpt.hidden = !showAll.checked;
        }
        defaultSelect.querySelectorAll('.default-opt-cat').forEach(opt => {
            const key = opt.dataset.category;
            const cb = document.querySelector(`.category-visible-cb[data-key="${key}"]`);
            const on = cb && cb.checked;
            opt.disabled = !on;
            opt.hidden = !on;
        });
        const firstValid = [...defaultSelect.options].find(o => !o.disabled && !o.hidden);
        if (![...defaultSelect.options].find(o => o.value === current && !o.disabled && !o.hidden)) {
            if (firstValid) defaultSelect.value = firstValid.value;
        }
    }

    showAll?.addEventListener('change', rebuildDefaultOptions);
    categoryCbs.forEach(cb => cb.addEventListener('change', rebuildDefaultOptions));
    rebuildDefaultOptions();
})();
</script>
@endpush

@endsection
