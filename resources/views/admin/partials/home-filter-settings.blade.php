{{-- فلتر «اختاري ما يناسبك» في الصفحة الرئيسية --}}
<form action="{{ route('admin.home-service-filters.update') }}" method="POST" class="space-y-5 mb-8">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">فلتر الموقع — «اختاري ما يناسبك»</h2>
        <p class="text-sm" style="color:#888">ما يظهر للزائر في الصفحة الرئيسية خارج اللوحة.</p>

        <label class="flex items-center gap-3 cursor-pointer p-4 rounded-xl" style="background:#fdf8f5; border:1px solid #f0e8e9">
            <input type="checkbox" name="show_all" value="1" class="w-5 h-5 rounded" style="accent-color:#c9888e"
                   {{ old('show_all', $filterConfig['show_all'] ? '1' : '0') ? 'checked' : '' }}
                   id="showAllCheckbox">
            <div>
                <span class="font-bold block" style="color:#1a1a1a">إظهار زر «الكل» مع الفلتر</span>
                <span class="text-xs" style="color:#888">إن ألغيتِه يظهر للزائر أقسام التصنيفات فقط بدون «الكل».</span>
            </div>
        </label>

        <div class="max-w-md">
            <label class="form-label">التبويب الافتراضي عند أول زيارة</label>
            <select name="default" id="defaultFilterSelect" class="form-input">
                @if(old('show_all', $filterConfig['show_all']))
                <option value="all" {{ old('default', $filterConfig['default']) === 'all' ? 'selected' : '' }}>الكل</option>
                @endif
                @foreach($filterCategoryLabels as $key => $label)
                @php $isOn = old("visible.$key", ($filterConfig['visible'][$key] ?? false) ? '1' : ''); @endphp
                <option value="{{ $key }}" data-category="{{ $key }}"
                        class="default-opt-cat"
                        {{ old('default', $filterConfig['default']) === $key ? 'selected' : '' }}
                        {{ $isOn ? '' : 'disabled hidden' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label mb-3 block">أي تصنيفات تظهر كأزرار في الفلتر؟</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($filterCategoryLabels as $key => $label)
                <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer"
                       style="border:1px solid #f0e8e9; background:#fdf8f5">
                    <input type="checkbox" name="visible[{{ $key }}]" value="1"
                           class="w-5 h-5 rounded category-visible-cb" style="accent-color:#c9888e"
                           data-key="{{ $key }}"
                           {{ old("visible.$key", ($filterConfig['visible'][$key] ?? false) ? '1' : '') ? 'checked' : '' }}>
                    <span class="font-bold text-sm" style="color:#1a1a1a">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn-primary">حفظ إعدادات الفلتر</button>
    </div>
</form>

@once
@push('scripts')
<script>
(function () {
    const showAll = document.getElementById('showAllCheckbox');
    const defaultSelect = document.getElementById('defaultFilterSelect');
    if (!showAll || !defaultSelect) return;

    const categoryCbs = document.querySelectorAll('.category-visible-cb');

    function rebuildDefaultOptions() {
        const current = defaultSelect.value;
        let allOpt = defaultSelect.querySelector('option[value="all"]');
        if (showAll.checked && !allOpt) {
            allOpt = document.createElement('option');
            allOpt.value = 'all';
            allOpt.textContent = 'الكل';
            defaultSelect.insertBefore(allOpt, defaultSelect.firstChild);
        }
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
        const valid = [...defaultSelect.options].find(o => o.value === current && !o.disabled && !o.hidden);
        if (!valid) {
            const first = [...defaultSelect.options].find(o => !o.disabled && !o.hidden);
            if (first) defaultSelect.value = first.value;
        }
    }

    showAll.addEventListener('change', rebuildDefaultOptions);
    categoryCbs.forEach(cb => cb.addEventListener('change', rebuildDefaultOptions));
    rebuildDefaultOptions();
})();
</script>
@endpush
@endonce
