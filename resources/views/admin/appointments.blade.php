@extends('layouts.admin')

@section('title', 'الحجوزات - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <h1 class="text-2xl font-black" style="color:#1a1a1a">جميع الحجوزات</h1>
    <button type="button" onclick="document.getElementById('createAppointmentModal').classList.remove('hidden')" class="btn-primary">
        + حجز جديد
    </button>
</div>

@if($errors->any())
<div class="mb-6 p-4 rounded-xl text-sm" style="background:#fee2e2; color:#dc2626;">
    <ul class="list-disc pr-5 space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('success'))
<div class="mb-6 p-4 rounded-xl text-sm font-bold" style="background:#d1fae5; color:#059669">{{ session('success') }}</div>
@endif

<div class="mb-6 p-4 rounded-xl text-sm leading-relaxed" style="background:#fdf8f5; border:1px solid #f0dde0; color:#555">
    <strong style="color:#1a1a1a">سير العمل:</strong>
    كل حجز جديد من الموقع يدخل بحالة <strong>انتظار</strong> — تواصلي مع العميلة عبر واتساب ثم غيّري الحالة إلى <strong>تأكيد</strong>.
    اختيار <strong>إلغاء</strong> يعني إلغاء الموعد (يُطلب تأكيد قبل الحفظ).
    <strong>تعديل الموعد</strong> يغيّر التاريخ والوقت بعد الاتفاق مع العميلة (الخدمة والأخصائية كما هي).
    <strong>حذف</strong> يزيل السجل نهائياً من النظام (لا يمكن التراجع).
    @if($appointments->where('status', 'cancelled')->count() > 0)
    <span class="block mt-2" style="color:#dc2626">
        يوجد حجوزات ملغية — إن أُلغيت بالخطأ، اختاري «انتظار» أو «تأكيد» من القائمة لاستعادتها.
    </span>
    @endif
</div>

{{-- Filters --}}
<form method="GET" class="bg-white rounded-2xl p-4 mb-6 flex flex-wrap gap-4 items-end shadow-sm">
    <div class="min-w-[140px]">
        <label class="form-label text-xs">الحالة</label>
        <select name="status" class="form-input text-sm" style="padding:0.5rem 0.875rem">
            <option value="">الكل</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>انتظار</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>مكتمل</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغي</option>
        </select>
    </div>
    <div class="min-w-[160px]">
        <label class="form-label text-xs">الخدمة</label>
        <select name="service_id" class="form-input text-sm" style="padding:0.5rem 0.875rem">
            <option value="">كل الخدمات</option>
            @foreach($bookableServices as $svc)
            <option value="{{ $svc->id }}" {{ (string) request('service_id') === (string) $svc->id ? 'selected' : '' }}>
                {{ $svc->name }}@if($svc->price) — {{ number_format($svc->price) }} د.ع@endif
            </option>
            @endforeach
        </select>
    </div>
    <div class="min-w-[140px]">
        <label class="form-label text-xs">التاريخ</label>
        <input type="date" name="date" value="{{ request('date') }}" class="form-input text-sm" style="padding:0.5rem 0.875rem">
    </div>
    <button type="submit" class="btn-primary text-sm" style="padding:0.5rem 1.25rem">بحث</button>
    <a href="{{ route('admin.appointments') }}" class="text-sm font-bold" style="color:#888; padding:0.5rem">إعادة ضبط</a>
</form>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead style="background:#fdf8f5">
                <tr>
                    <th class="p-4 text-right font-bold" style="color:#555">#</th>
                    <th class="p-4 text-right font-bold" style="color:#555">العميلة</th>
                    <th class="p-4 text-right font-bold" style="color:#555">الخدمة</th>
                    <th class="p-4 text-right font-bold" style="color:#555">الموعد</th>
                    <th class="p-4 text-right font-bold" style="color:#555">الحالة</th>
                    <th class="p-4 text-right font-bold" style="color:#555">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $a)
                @php
                $statusConfig = [
                    'pending'   => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'⏳ انتظار'],
                    'confirmed' => ['bg'=>'#d1fae5','color'=>'#059669','label'=>'✅ مؤكد'],
                    'cancelled' => ['bg'=>'#fee2e2','color'=>'#dc2626','label'=>'❌ ملغي'],
                    'completed' => ['bg'=>'#dbeafe','color'=>'#2563eb','label'=>'🏁 مكتمل'],
                ];
                $sc = $statusConfig[$a->status] ?? ['bg'=>'#f3f4f6','color'=>'#666','label'=>$a->status];
                @endphp
                <tr style="border-top:1px solid #f5f0f0; transition:background 0.2s" onmouseover="this.style.background='#fdf8f5'" onmouseout="this.style.background=''">
                    <td class="p-4" style="color:#888">#{{ str_pad($a->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="p-4">
                        <div class="font-bold" style="color:#1a1a1a">{{ $a->client_name }}</div>
                        <div class="text-xs" style="color:#888">{{ $a->client_phone }}</div>
                        @if($a->client_email)
                        <div class="text-xs" style="color:#aaa">{{ $a->client_email }}</div>
                        @endif
                    </td>
                    <td class="p-4" style="color:#1a1a1a">
                        <div class="font-bold" style="color:#1a1a1a">{{ $a->service->name ?? '-' }}</div>
                        @if($a->staff)
                        <div class="text-xs" style="color:#888">{{ $a->staff->name }}</div>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="font-bold">{{ $a->appointment_date->format('Y/m/d') }}</div>
                        <div class="text-xs" style="color:#888">{{ substr($a->appointment_time, 0, 5) }}</div>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold"
                              style="background:{{ $sc['bg'] }}; color:{{ $sc['color'] }}">
                            {{ $sc['label'] }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-wrap items-center gap-2">
                            @if($a->status !== 'cancelled')
                            <button type="button"
                                    class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all hover:opacity-80"
                                    style="background:#e0e7ff; color:#4338ca"
                                    title="تعديل التاريخ والوقت"
                                    onclick="openRescheduleModal(this)"
                                    data-id="{{ $a->id }}"
                                    data-label="#{{ str_pad($a->id, 4, '0', STR_PAD_LEFT) }}"
                                    data-client="{{ $a->client_name }}"
                                    data-service="{{ $a->service->name ?? '-' }}"
                                    data-service-id="{{ $a->service_id }}"
                                    data-staff-id="{{ $a->staff_id ?? '' }}"
                                    data-date="{{ $a->appointment_date->format('Y-m-d') }}"
                                    data-time="{{ substr($a->appointment_time, 0, 5) }}">
                                تعديل الموعد
                            </button>
                            @endif
                            <form method="POST" action="{{ route('admin.appointments.status', $a) }}" class="appointment-status-form">
                                @csrf @method('PATCH')
                                <select name="status"
                                        data-current="{{ $a->status }}"
                                        onchange="handleAppointmentStatusChange(this)"
                                        class="admin-select text-xs rounded-lg px-2 py-1.5 border font-bold cursor-pointer">
                                    <option value="pending"   {{ $a->status === 'pending' ? 'selected' : '' }}>انتظار</option>
                                    <option value="confirmed" {{ $a->status === 'confirmed' ? 'selected' : '' }}>تأكيد</option>
                                    <option value="completed" {{ $a->status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="cancelled" {{ $a->status === 'cancelled' ? 'selected' : '' }}>إلغاء</option>
                                </select>
                            </form>
                            <form method="POST" action="{{ route('admin.appointments.destroy', $a) }}"
                                  onsubmit="return confirm('حذف الحجز #{{ str_pad($a->id, 4, '0', STR_PAD_LEFT) }} نهائياً؟\n\nلا يمكن التراجع عن الحذف.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all hover:opacity-80"
                                        style="background:#fee2e2; color:#dc2626"
                                        title="حذف السجل">
                                    <span class="inline-flex items-center gap-1">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                        حذف
                                    </span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-12 text-center" style="color:#aaa">لا توجد حجوزات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($appointments->hasPages())
    <div class="p-4" style="border-top:1px solid #f0e8e9">
        {{ $appointments->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- Reschedule appointment modal --}}
<div id="rescheduleAppointmentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.55)">
    <div class="bg-white rounded-2xl p-8 w-full shadow-xl max-h-[92vh] overflow-y-auto" style="max-width:480px">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-black" style="color:#1a1a1a">تعديل موعد الحجز</h2>
                <p class="text-sm mt-1" id="rescheduleModalSubtitle" style="color:#888"></p>
            </div>
            <button type="button" onclick="document.getElementById('rescheduleAppointmentModal').classList.add('hidden')"
                    class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:#f5f5f5; color:#888">✕</button>
        </div>

        <form method="POST" id="rescheduleForm" class="space-y-4">
            @csrf
            @method('PATCH')
            <input type="hidden" name="reschedule_appointment_id" id="rescheduleAppointmentId" value="{{ old('reschedule_appointment_id') }}">

            <div class="p-3 rounded-xl text-sm" style="background:#fdf8f5; color:#555">
                <div><strong>الخدمة:</strong> <span id="rescheduleServiceName">—</span></div>
            </div>

            <div>
                <label class="form-label">تاريخ الموعد الجديد *</label>
                <input type="date" name="appointment_date" id="rescheduleDateInput" class="form-input" required>
            </div>
            <div>
                <label class="form-label">وقت الموعد الجديد *</label>
                <select name="appointment_time" id="rescheduleTimeSelect" class="form-input" required>
                    <option value="">— اختاري التاريخ —</option>
                </select>
            </div>
            <p class="text-xs" style="color:#888">يُعرض الوقت الحالي ضمن الخيارات إن كان لا يزال متاحاً. تذكير واتساب يُعاد جدولته للموعد الجديد.</p>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center">حفظ الموعد الجديد</button>
                <button type="button" class="flex-1 py-3 rounded-xl font-bold" style="background:#f5f0f0; color:#666"
                        onclick="document.getElementById('rescheduleAppointmentModal').classList.add('hidden')">إلغاء</button>
            </div>
        </form>
    </div>
</div>

{{-- Create appointment modal --}}
<div id="createAppointmentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.55)">
    <div class="bg-white rounded-2xl p-8 w-full shadow-xl max-h-[92vh] overflow-y-auto" style="max-width:640px">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-black" style="color:#1a1a1a">حجز جديد من اللوحة</h2>
            <button type="button" onclick="document.getElementById('createAppointmentModal').classList.add('hidden')"
                    class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:#f5f5f5; color:#888">✕</button>
        </div>

        <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-4" id="adminBookingForm">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">اسم العميلة *</label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">رقم الهاتف *</label>
                    <input type="tel" name="client_phone" value="{{ old('client_phone') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">البريد (اختياري)</label>
                    <input type="email" name="client_email" value="{{ old('client_email') }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">الحالة *</label>
                    <select name="status" class="form-input">
                        <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>انتظار</option>
                        <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">الخدمة *</label>
                    <select name="service_id" id="adminServiceSelect" class="form-input" required>
                        <option value="">— اختاري الخدمة —</option>
                        @foreach($bookableServices as $svc)
                        <option value="{{ $svc->id }}"
                                data-duration="{{ $svc->duration_minutes }}"
                                data-price="{{ $svc->price }}"
                                {{ (string) old('service_id') === (string) $svc->id ? 'selected' : '' }}>
                            {{ $svc->name }}@if($svc->price) — {{ number_format($svc->price) }} د.ع@endif ({{ $svc->duration_minutes }} د)
                        </option>
                        @endforeach
                    </select>
                    <p class="text-xs mt-1" id="adminServiceMeta" style="color:#888"></p>
                </div>
                <div>
                    <label class="form-label">الأخصائية (اختياري)</label>
                    <select name="staff_id" id="adminStaffSelect" class="form-input" disabled>
                        <option value="">— اختاري الخدمة أولاً —</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">تاريخ الموعد *</label>
                    <input type="date" name="appointment_date" id="adminDateInput" value="{{ old('appointment_date', date('Y-m-d')) }}"
                           class="form-input" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">وقت الموعد *</label>
                    <select name="appointment_time" id="adminTimeSelect" class="form-input" required>
                        <option value="">— اختاري الخدمة والتاريخ —</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">ملاحظات</label>
                    <textarea name="notes" rows="2" class="form-input" placeholder="اختياري">{{ old('notes') }}</textarea>
                </div>
            </div>
            <p class="text-xs" style="color:#888">الأوقات المتاحة تُحسب حسب الجهاز والأخصائية — كما في حجز الموقع.</p>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center">حفظ الحجز</button>
                <button type="button" class="flex-1 py-3 rounded-xl font-bold" style="background:#f5f0f0; color:#666"
                        onclick="document.getElementById('createAppointmentModal').classList.add('hidden')">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
const adminServiceSelect = document.getElementById('adminServiceSelect');
const adminStaffSelect = document.getElementById('adminStaffSelect');
const adminDateInput = document.getElementById('adminDateInput');
const adminTimeSelect = document.getElementById('adminTimeSelect');
const adminServiceMeta = document.getElementById('adminServiceMeta');
const preselectedAdminServiceId = @json(old('service_id'));
const preselectedAdminStaffId = @json(old('staff_id'));
const preselectedAdminTime = @json(old('appointment_time'));

const rescheduleModal = document.getElementById('rescheduleAppointmentModal');
const rescheduleForm = document.getElementById('rescheduleForm');
const rescheduleDateInput = document.getElementById('rescheduleDateInput');
const rescheduleTimeSelect = document.getElementById('rescheduleTimeSelect');
const rescheduleAppointmentId = document.getElementById('rescheduleAppointmentId');
const rescheduleModalSubtitle = document.getElementById('rescheduleModalSubtitle');
const rescheduleServiceName = document.getElementById('rescheduleServiceName');
const scheduleUrlBase = @json(url('/admin/appointments'));
let rescheduleServiceId = null;
let rescheduleStaffId = null;
let reschedulePreferredTime = null;
const preselectedRescheduleId = @json(old('reschedule_appointment_id'));
const preselectedRescheduleDate = @json(old('appointment_date'));
const preselectedRescheduleTime = @json(old('appointment_time'));

function updateAdminServiceMeta() {
    const opt = adminServiceSelect.selectedOptions[0];
    if (!opt || !opt.value) {
        adminServiceMeta.textContent = '';
        return;
    }
    const dur = opt.dataset.duration;
    const price = opt.dataset.price;
    let t = `المدة: ${dur} دقيقة`;
    if (price) t += ` — السعر: ${Number(price).toLocaleString('ar-IQ')} د.ع`;
    adminServiceMeta.textContent = t;
}

async function loadAdminStaff() {
    const serviceId = adminServiceSelect.value;
    if (!serviceId) {
        adminStaffSelect.innerHTML = '<option value="">— اختاري الخدمة أولاً —</option>';
        adminStaffSelect.disabled = true;
        return;
    }
    adminStaffSelect.innerHTML = '<option>جاري التحميل...</option>';
    adminStaffSelect.disabled = true;
    try {
        const res = await fetch(`{{ route('booking.staff') }}?service_id=${serviceId}`);
        const staff = await res.json();
        adminStaffSelect.innerHTML = '';
        const ph = document.createElement('option');
        ph.value = '';
        ph.textContent = '— بدون تفضيل (اختياري) —';
        adminStaffSelect.appendChild(ph);
        staff.forEach(s => {
            const o = document.createElement('option');
            o.value = s.id;
            o.textContent = s.role ? `${s.name} — ${s.role}` : s.name;
            adminStaffSelect.appendChild(o);
        });
        adminStaffSelect.disabled = false;
        if (preselectedAdminStaffId) {
            adminStaffSelect.value = preselectedAdminStaffId;
        }
    } catch (e) {
        adminStaffSelect.innerHTML = '<option value="">تعذر تحميل الأخصائيات</option>';
    }
    loadAdminTimes();
}

function formatAdminTimeLabel(t) {
    const [h, m] = t.split(':');
    const hour = parseInt(h, 10);
    const ampm = hour >= 12 ? 'م' : 'ص';
    const displayH = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
    return `${displayH}:${m} ${ampm}`;
}

async function loadAdminTimes() {
    const date = adminDateInput.value;
    const serviceId = adminServiceSelect.value;
    if (!date || !serviceId) {
        adminTimeSelect.innerHTML = '<option value="">— اختاري الخدمة والتاريخ —</option>';
        return;
    }
    adminTimeSelect.innerHTML = '<option>جاري التحميل...</option>';
    try {
        let url = `{{ route('booking.times') }}?date=${date}&service_id=${serviceId}`;
        if (adminStaffSelect.value) url += `&staff_id=${adminStaffSelect.value}`;
        const res = await fetch(url);
        const times = await res.json();
        adminTimeSelect.innerHTML = '';
        if (!times.length) {
            adminTimeSelect.innerHTML = '<option value="">لا توجد أوقات متاحة</option>';
            return;
        }
        times.forEach(t => {
            const o = document.createElement('option');
            o.value = t;
            o.textContent = formatAdminTimeLabel(t);
            adminTimeSelect.appendChild(o);
        });
        if (preselectedAdminTime) {
            const t5 = String(preselectedAdminTime).substring(0, 5);
            if ([...adminTimeSelect.options].some(o => o.value === t5)) {
                adminTimeSelect.value = t5;
            }
        }
    } catch (e) {
        adminTimeSelect.innerHTML = '<option value="">تعذر تحميل الأوقات</option>';
    }
}

adminServiceSelect?.addEventListener('change', () => {
    updateAdminServiceMeta();
    loadAdminStaff();
});
adminStaffSelect?.addEventListener('change', loadAdminTimes);
adminDateInput?.addEventListener('change', loadAdminTimes);

document.getElementById('createAppointmentModal')?.addEventListener('click', function(e) {
    if (e.target === this) this.classList.add('hidden');
});

rescheduleModal?.addEventListener('click', function(e) {
    if (e.target === this) this.classList.add('hidden');
});

function openRescheduleModal(btn) {
    const id = btn.dataset.id;
    rescheduleAppointmentId.value = id;
    rescheduleForm.action = `${scheduleUrlBase}/${id}/schedule`;
    rescheduleModalSubtitle.textContent = `${btn.dataset.label} — ${btn.dataset.client}`;
    rescheduleServiceName.textContent = btn.dataset.service;
    rescheduleServiceId = btn.dataset.serviceId;
    rescheduleStaffId = btn.dataset.staffId || '';
    reschedulePreferredTime = btn.dataset.time;
    rescheduleDateInput.value = btn.dataset.date;
    rescheduleModal.classList.remove('hidden');
    loadRescheduleTimes();
}

async function loadRescheduleTimes() {
    const date = rescheduleDateInput.value;
    const appointmentId = rescheduleAppointmentId.value;
    if (!date || !rescheduleServiceId || !appointmentId) {
        rescheduleTimeSelect.innerHTML = '<option value="">— اختاري التاريخ —</option>';
        return;
    }
    rescheduleTimeSelect.innerHTML = '<option>جاري التحميل...</option>';
    try {
        let url = `{{ route('booking.times') }}?date=${date}&service_id=${rescheduleServiceId}&except_appointment_id=${appointmentId}`;
        if (rescheduleStaffId) url += `&staff_id=${rescheduleStaffId}`;
        const res = await fetch(url);
        const times = await res.json();
        rescheduleTimeSelect.innerHTML = '';
        if (!times.length) {
            rescheduleTimeSelect.innerHTML = '<option value="">لا توجد أوقات متاحة</option>';
            return;
        }
        times.forEach(t => {
            const o = document.createElement('option');
            o.value = t;
            o.textContent = formatAdminTimeLabel(t);
            rescheduleTimeSelect.appendChild(o);
        });
        const pick = preselectedRescheduleTime
            ? String(preselectedRescheduleTime).substring(0, 5)
            : reschedulePreferredTime;
        if (pick && [...rescheduleTimeSelect.options].some(o => o.value === pick)) {
            rescheduleTimeSelect.value = pick;
        }
    } catch (e) {
        rescheduleTimeSelect.innerHTML = '<option value="">تعذر تحميل الأوقات</option>';
    }
}

rescheduleDateInput?.addEventListener('change', () => {
    reschedulePreferredTime = null;
    loadRescheduleTimes();
});

@if($errors->any() && old('client_name'))
document.getElementById('createAppointmentModal')?.classList.remove('hidden');
updateAdminServiceMeta();
loadAdminStaff();
@endif

@if($errors->any() && old('reschedule_appointment_id'))
(function reopenRescheduleFromValidation() {
    const id = @json(old('reschedule_appointment_id'));
    const btn = document.querySelector(`button[data-id="${id}"][onclick="openRescheduleModal(this)"]`);
    if (btn) {
        openRescheduleModal(btn);
        if (@json(old('appointment_date'))) {
            rescheduleDateInput.value = @json(old('appointment_date'));
            loadRescheduleTimes();
        }
    } else {
        rescheduleAppointmentId.value = id;
        rescheduleForm.action = `${scheduleUrlBase}/${id}/schedule`;
        rescheduleDateInput.value = @json(old('appointment_date', ''));
        rescheduleModal.classList.remove('hidden');
        loadRescheduleTimes();
    }
})();
@endif

if (preselectedAdminServiceId && adminServiceSelect) {
    adminServiceSelect.value = preselectedAdminServiceId;
    updateAdminServiceMeta();
    loadAdminStaff();
}

function handleAppointmentStatusChange(select) {
    const previous = select.dataset.current;
    const next = select.value;

    if (next === previous) {
        return;
    }

    if (next === 'cancelled') {
        const rowId = select.closest('tr')?.querySelector('td')?.textContent?.trim() || '';
        const ok = confirm(
            'هل تريد إلغاء الحجز ' + rowId + '؟\n\n' +
            'الحجز يبقى في السجل لكن يُعلَّم ملغياً. يمكنك استعادته لاحقاً باختيار «انتظار» أو «تأكيد».'
        );
        if (!ok) {
            select.value = previous;
            return;
        }
    }

    if (next === 'completed') {
        const ok = confirm('هل تريد تعليم هذا الحجز كمكتمل؟');
        if (!ok) {
            select.value = previous;
            return;
        }
    }

    select.form.submit();
}
</script>
@endpush

@endsection
