@extends('layouts.app')

@section('title', 'احجزي موعدك - NAY SPA')

@section('content')

<div class="page-header">
    <div class="badge-spa mb-4 inline-flex" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.3)">حجز موعد</div>
    <h1 class="text-4xl font-black text-white mb-3">احجزي موعدك</h1>
    <p style="color:rgba(255,255,255,0.65)">خطوات بسيطة لحجز موعدك المثالي</p>
</div>

<section class="py-16" style="background:#1a1a1a">
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    @if($errors->any())
    <div class="mb-6 p-4 rounded-2xl text-sm" style="background:rgba(220,38,38,0.15); color:#fca5a5; border:1px solid rgba(220,38,38,0.3)">
        <div class="font-bold mb-2">⚠️ يرجى تصحيح الأخطاء التالية:</div>
        <ul class="space-y-1 list-disc list-inside">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="rounded-3xl overflow-hidden" style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.12); box-shadow:0 20px 60px rgba(0,0,0,0.4)">

        {{-- Form Header --}}
        <div class="p-6" style="background:linear-gradient(135deg,rgba(232,180,184,0.12),rgba(61,43,46,0.5)); border-bottom:1px solid rgba(232,180,184,0.15)">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0"
                     style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-white">نموذج الحجز</h2>
                    <p class="text-sm" style="color:rgba(255,255,255,0.5)">أكملي البيانات التالية لتأكيد حجزك</p>
                </div>
            </div>
        </div>

        <form action="{{ route('booking.store') }}" method="POST" class="p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Name --}}
                <div>
                    <label class="booking-label">الاسم الكامل <span style="color:#e8b4b8">*</span></label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}"
                           class="booking-input" placeholder="أدخلي اسمك الكامل" required>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="booking-label">رقم الهاتف <span style="color:#e8b4b8">*</span></label>
                    <input type="tel" name="client_phone" value="{{ old('client_phone') }}"
                           class="booking-input" placeholder="{{ $siteContact['phone'] }}" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="booking-label">البريد الإلكتروني <span style="color:rgba(255,255,255,0.4); font-weight:400;">(اختياري)</span></label>
                    <input type="text" name="client_email" value="{{ old('client_email') }}"
                           class="booking-input" placeholder="example@email.com"
                           inputmode="email" autocomplete="email"
                           style="direction:ltr; text-align:left; color:#fff;">
                </div>

                {{-- Category (step 1) --}}
                @php
                    $preselectedCategory = null;
                    if (old('service_id')) {
                        $preselectedCategory = optional($services->firstWhere('id', (int) old('service_id')))->category ?: 'other';
                    } elseif ($selectedService) {
                        $preselectedCategory = $selectedService->category ?: 'other';
                    }
                @endphp
                <div>
                    <label class="booking-label">القسم <span style="color:#e8b4b8">*</span></label>
                    <p class="text-xs mb-2" style="color:rgba(255,255,255,0.4);">اختاري القسم أولاً — بدون سعر</p>
                    <select class="booking-input" id="categorySelect" required>
                        <option value="">— اختاري القسم —</option>
                        @foreach($categoryLabels as $key => $label)
                            @if(($servicesByCategory[$key] ?? collect())->isNotEmpty())
                            <option value="{{ $key }}" {{ $preselectedCategory === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endif
                        @endforeach
                        @if(($servicesByCategory['other'] ?? collect())->isNotEmpty())
                        <option value="other" {{ $preselectedCategory === 'other' ? 'selected' : '' }}>أخرى</option>
                        @endif
                    </select>
                </div>

                {{-- Service (step 2) — السعر والمدة على الخدمة الفرعية --}}
                <div>
                    <label class="booking-label">الخدمة الفرعية <span style="color:#e8b4b8">*</span></label>
                    <p class="text-xs mb-2" style="color:rgba(255,255,255,0.4);">السعر ومدة الجلسة تظهر مع كل خدمة</p>
                    <select name="service_id" class="booking-input" required id="serviceSelect" disabled>
                        <option value="">— اختاري القسم أولاً —</option>
                    </select>
                    <p class="text-xs mt-2 hidden" id="serviceMeta" style="color:rgba(232,180,184,0.85);"></p>
                </div>

                {{-- Staff — تظهر بعد اختيار الخدمة --}}
                <div id="staffField">
                    <label class="booking-label">الأخصائية <span style="color:#e8b4b8">*</span></label>
                    <p class="text-xs mb-2" style="color:rgba(255,255,255,0.4);">تُعرض المختصات المؤهلات لهذه الخدمة فقط</p>
                    <select name="staff_id" class="booking-input" id="staffSelect" disabled>
                        <option value="">— اختاري الخدمة أولاً —</option>
                    </select>
                </div>

                {{-- Date --}}
                <div>
                    <label class="booking-label">تاريخ الموعد <span style="color:#e8b4b8">*</span></label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}"
                           class="booking-input" id="dateInput" min="{{ date('Y-m-d') }}" required>
                </div>

                {{-- Time --}}
                <div>
                    <label class="booking-label">وقت الموعد <span style="color:#e8b4b8">*</span></label>
                    <select name="appointment_time" class="booking-input" id="timeSelect" required>
                        <option value="">— اختاري التاريخ أولاً —</option>
                    </select>
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2">
                    <label class="booking-label">ملاحظات إضافية</label>
                    <textarea name="notes" class="booking-input" rows="3"
                              placeholder="أي تفاصيل أو طلبات خاصة...">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Info box --}}
            <div class="mt-6 p-4 rounded-2xl flex items-start gap-3"
                 style="background:rgba(232,180,184,0.07); border:1px solid rgba(232,180,184,0.2)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" class="flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div class="text-sm" style="color:rgba(255,255,255,0.6)">
                    <strong class="block mb-1 text-white">تذكيري:</strong>
                    الأوقات المتاحة تُحسب حسب مدة الخدمة والجهاز والأخصائية المختارة.
                    سيتم التواصل معك عبر واتساب لتأكيد الموعد خلال ٣٠ دقيقة من الحجز.
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="btn-primary text-base flex-1 justify-center py-4">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    تأكيد الحجز
                </button>
                <a href="{{ route('home') }}" class="px-6 py-4 rounded-full font-bold transition-all hover:opacity-70"
                   style="background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.6)">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
</section>

@endsection

@push('scripts')
<script>
const dateInput = document.getElementById('dateInput');
const timeSelect = document.getElementById('timeSelect');
const serviceSelect = document.getElementById('serviceSelect');
const categorySelect = document.getElementById('categorySelect');
const staffSelect = document.getElementById('staffSelect');
const serviceMeta = document.getElementById('serviceMeta');
const servicesByCategory = @json($servicesForBooking);
const preselectedServiceId = @json(old('service_id') ?: ($selectedService?->id));
const preselectedStaffId = @json(old('staff_id'));

function findService(id) {
    for (const cat of Object.values(servicesByCategory)) {
        const found = cat.find(s => s.id == id);
        if (found) return found;
    }
    return null;
}

function updateServiceMeta() {
    const s = findService(serviceSelect.value);
    if (!s) {
        serviceMeta.classList.add('hidden');
        return;
    }
    let text = `⏱ مدة الجلسة: ${s.duration_minutes} دقيقة`;
    if (s.equipment) text += ` · جهاز: ${s.equipment}`;
    serviceMeta.textContent = text;
    serviceMeta.classList.remove('hidden');
}

function updateServiceOptions() {
    const cat = categorySelect.value;
    const list = servicesByCategory[cat] || [];

    serviceSelect.innerHTML = '';
    const placeholder = document.createElement('option');
    placeholder.value = '';

    if (!cat) {
        placeholder.textContent = '— اختاري القسم أولاً —';
        serviceSelect.appendChild(placeholder);
        serviceSelect.disabled = true;
        resetStaffSelect();
        return;
    }

    placeholder.textContent = list.length ? '— اختاري الخدمة —' : '— لا توجد خدمات في هذا القسم —';
    serviceSelect.appendChild(placeholder);

    list.forEach(s => {
        const opt = document.createElement('option');
        opt.value = s.id;
        let label = s.name;
        if (s.price) label += ` — ${Number(s.price).toLocaleString('ar-IQ')} د.ع`;
        label += ` (${s.duration_minutes} د)`;
        opt.textContent = label;
        serviceSelect.appendChild(opt);
    });

    serviceSelect.disabled = list.length === 0;

    if (preselectedServiceId && list.some(s => s.id == preselectedServiceId)) {
        serviceSelect.value = preselectedServiceId;
    } else if (list.length === 1) {
        serviceSelect.value = list[0].id;
    }

    updateServiceMeta();
    loadStaffForService();
}

function resetStaffSelect(msg = '— اختاري الخدمة أولاً —') {
    staffSelect.innerHTML = `<option value="">${msg}</option>`;
    staffSelect.disabled = true;
    staffSelect.value = '';
}

async function loadStaffForService() {
    const serviceId = serviceSelect.value;
    if (!serviceId) {
        resetStaffSelect();
        resetTimesSelect();
        return;
    }

    staffSelect.innerHTML = '<option>جاري التحميل...</option>';
    staffSelect.disabled = true;

    try {
        const res = await fetch(`{{ route('booking.staff') }}?service_id=${serviceId}`);
        const staff = await res.json();

        staffSelect.innerHTML = '';
        if (staff.length === 0) {
            staffSelect.innerHTML = '<option value="">— أي أخصائية متاحة —</option>';
            staffSelect.disabled = false;
            staffSelect.removeAttribute('required');
        } else {
            const ph = document.createElement('option');
            ph.value = '';
            ph.textContent = '— اختاري الأخصائية —';
            staffSelect.appendChild(ph);
            staff.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.id;
                opt.textContent = s.role ? `${s.name} — ${s.role}` : s.name;
                staffSelect.appendChild(opt);
            });
            staffSelect.disabled = false;
            staffSelect.setAttribute('required', 'required');
            if (preselectedStaffId && staff.some(s => s.id == preselectedStaffId)) {
                staffSelect.value = preselectedStaffId;
            } else if (staff.length === 1) {
                staffSelect.value = staff[0].id;
            }
        }
        loadTimes();
    } catch (e) {
        resetStaffSelect('تعذر تحميل الأخصائيات');
    }
}

function resetTimesSelect(msg = '— اختاري التاريخ والخدمة —') {
    timeSelect.innerHTML = `<option value="">${msg}</option>`;
}

function formatTimeLabel(t) {
    const [h, m] = t.split(':');
    const hour = parseInt(h, 10);
    const ampm = hour >= 12 ? 'م' : 'ص';
    const displayH = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
    return `${displayH}:${m} ${ampm}`;
}

async function loadTimes() {
    const date = dateInput.value;
    const serviceId = serviceSelect.value;
    if (!date || !serviceId) {
        resetTimesSelect();
        return;
    }

    const staffId = staffSelect.value;
    if (staffSelect.hasAttribute('required') && !staffId) {
        resetTimesSelect('— اختاري الأخصائية أولاً —');
        return;
    }

    timeSelect.innerHTML = '<option>جاري التحميل...</option>';

    try {
        let url = `{{ route('booking.times') }}?date=${date}&service_id=${serviceId}`;
        if (staffId) url += `&staff_id=${staffId}`;
        const res = await fetch(url);
        const times = await res.json();

        timeSelect.innerHTML = '<option value="">— اختاري الوقت —</option>';
        if (times.length === 0) {
            timeSelect.innerHTML = '<option value="">لا يوجد أوقات متاحة — جرّبي تاريخاً أو أخصائية أخرى</option>';
            return;
        }
        times.forEach(t => {
            timeSelect.innerHTML += `<option value="${t}">${formatTimeLabel(t)}</option>`;
        });
    } catch (e) {
        resetTimesSelect('تعذر تحميل الأوقات');
    }
}

categorySelect.addEventListener('change', () => {
    updateServiceOptions();
});

serviceSelect.addEventListener('change', () => {
    updateServiceMeta();
    loadStaffForService();
});

staffSelect.addEventListener('change', loadTimes);
dateInput.addEventListener('change', loadTimes);

updateServiceOptions();
if (preselectedServiceId) {
    loadStaffForService();
}
</script>
@endpush
