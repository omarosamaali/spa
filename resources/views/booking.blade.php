@extends('layouts.app')

@section('title', 'احجزي موعدك - NAY SPA')

@section('content')

<div class="page-header">
    <div class="badge-spa mb-4 inline-flex" style="background:rgba(232,180,184,0.15); color:#e8b4b8">حجز موعد</div>
    <h1 class="text-4xl font-black text-white mb-3">احجزي موعدك</h1>
    <p style="color:rgba(255,255,255,0.65)">خطوات بسيطة لحجز موعدك المثالي</p>
</div>

<section class="py-16" style="background:#fdf8f5">
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    @if($errors->any())
    <div class="mb-6 p-4 rounded-2xl text-sm" style="background:#fee2e2; color:#dc2626; border:1px solid #fca5a5">
        <div class="font-bold mb-2">⚠️ يرجى تصحيح الأخطاء التالية:</div>
        <ul class="space-y-1 list-disc list-inside">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden" style="box-shadow:0 20px 60px rgba(232,180,184,0.15)">

        {{-- Form Header --}}
        <div class="p-6" style="background:linear-gradient(135deg,#f5dfe1,#fdf8f5); border-bottom:2px solid #f0dde0">
            <div class="flex items-center gap-3">
                <div class="icon-circle text-2xl">🌸</div>
                <div>
                    <h2 class="text-xl font-black" style="color:#1a1a1a">نموذج الحجز</h2>
                    <p class="text-sm" style="color:#888">أكملي البيانات التالية لتأكيد حجزك</p>
                </div>
            </div>
        </div>

        <form action="{{ route('booking.store') }}" method="POST" class="p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Name --}}
                <div>
                    <label class="form-label">الاسم الكامل <span style="color:#c9888e">*</span></label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}"
                           class="form-input" placeholder="أدخلي اسمك الكامل" required>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="form-label">رقم الهاتف <span style="color:#c9888e">*</span></label>
                    <input type="tel" name="client_phone" value="{{ old('client_phone') }}"
                           class="form-input" placeholder="+964 770 123 4567" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="form-label">البريد الإلكتروني (اختياري)</label>
                    <input type="email" name="client_email" value="{{ old('client_email') }}"
                           class="form-input" placeholder="example@email.com">
                </div>

                {{-- Service --}}
                <div>
                    <label class="form-label">الخدمة المطلوبة <span style="color:#c9888e">*</span></label>
                    <select name="service_id" class="form-input" required id="serviceSelect">
                        <option value="">— اختاري الخدمة —</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}"
                            {{ (old('service_id') == $service->id || ($selectedService && $selectedService->id == $service->id)) ? 'selected' : '' }}>
                            {{ $service->icon ?? '' }} {{ $service->name }}
                            @if($service->price) - {{ number_format($service->price) }} د.ع @endif
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Staff --}}
                @if($staff->count())
                <div>
                    <label class="form-label">اختاري الأخصائية (اختياري)</label>
                    <select name="staff_id" class="form-input">
                        <option value="">— أي أخصائية متاحة —</option>
                        @foreach($staff as $s)
                        <option value="{{ $s->id }}" {{ old('staff_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }} @if($s->role) - {{ $s->role }} @endif
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Date --}}
                <div>
                    <label class="form-label">تاريخ الموعد <span style="color:#c9888e">*</span></label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}"
                           class="form-input" id="dateInput" min="{{ date('Y-m-d') }}" required>
                </div>

                {{-- Time --}}
                <div>
                    <label class="form-label">وقت الموعد <span style="color:#c9888e">*</span></label>
                    <select name="appointment_time" class="form-input" id="timeSelect" required>
                        <option value="">— اختاري التاريخ أولاً —</option>
                    </select>
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2">
                    <label class="form-label">ملاحظات إضافية</label>
                    <textarea name="notes" class="form-input" rows="3"
                              placeholder="أي تفاصيل أو طلبات خاصة...">{{ old('notes') }}</textarea>
                </div>
            </div>

            {{-- Info box --}}
            <div class="mt-6 p-4 rounded-2xl flex items-start gap-3" style="background:rgba(232,180,184,0.08); border:1px solid rgba(232,180,184,0.25)">
                <span class="text-xl mt-0.5">ℹ️</span>
                <div class="text-sm" style="color:#555">
                    <strong class="block mb-1" style="color:#1a1a1a">تذكيري:</strong>
                    سيتم التواصل معك عبر واتساب لتأكيد الموعد خلال ٣٠ دقيقة من الحجز.
                    في حال الرغبة بالإلغاء يرجى الإخطار قبل ٢٤ ساعة.
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="btn-primary text-base flex-1 justify-center py-4">
                    ✅ تأكيد الحجز
                </button>
                <a href="{{ route('home') }}" class="px-6 py-4 rounded-full font-bold transition-all hover:opacity-70" style="background:#f0e8e9; color:#888">
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

async function loadTimes() {
    const date = dateInput.value;
    const serviceId = serviceSelect.value;
    if (!date) return;

    timeSelect.innerHTML = '<option>جاري التحميل...</option>';

    try {
        const url = `{{ route('booking.times') }}?date=${date}&service_id=${serviceId}`;
        const res = await fetch(url);
        const times = await res.json();

        timeSelect.innerHTML = '<option value="">— اختاري الوقت —</option>';
        if (times.length === 0) {
            timeSelect.innerHTML = '<option value="">لا يوجد أوقات متاحة في هذا اليوم</option>';
            return;
        }
        times.forEach(t => {
            const [h, m] = t.split(':');
            const hour = parseInt(h);
            const ampm = hour >= 12 ? 'م' : 'ص';
            const displayH = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
            const label = `${displayH}:${m} ${ampm}`;
            timeSelect.innerHTML += `<option value="${t}">${label}</option>`;
        });
    } catch(e) {
        // Fallback: show default time slots
        const slots = ['10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00'];
        timeSelect.innerHTML = '<option value="">— اختاري الوقت —</option>';
        slots.forEach(t => {
            const [h, m] = t.split(':');
            const hour = parseInt(h);
            const ampm = hour >= 12 ? 'م' : 'ص';
            const displayH = hour > 12 ? hour - 12 : hour;
            timeSelect.innerHTML += `<option value="${t}">${displayH}:${m} ${ampm}</option>`;
        });
    }
}

dateInput.addEventListener('change', loadTimes);
serviceSelect.addEventListener('change', loadTimes);

// Trigger if date already selected (e.g. old value)
if (dateInput.value) loadTimes();
</script>
@endpush
