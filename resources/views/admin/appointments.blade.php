@extends('layouts.admin')

@section('title', 'الحجوزات - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <h1 class="text-2xl font-black" style="color:#1a1a1a">جميع الحجوزات</h1>
    <a href="{{ route('booking') }}" class="btn-primary">+ حجز جديد</a>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl text-sm font-bold" style="background:#d1fae5; color:#059669">{{ session('success') }}</div>
@endif

<div class="mb-6 p-4 rounded-xl text-sm leading-relaxed" style="background:#fdf8f5; border:1px solid #f0dde0; color:#555">
    <strong style="color:#1a1a1a">سير العمل:</strong>
    كل حجز جديد من الموقع يدخل بحالة <strong>انتظار</strong> — تواصلي مع العميلة عبر واتساب ثم غيّري الحالة إلى <strong>تأكيد</strong>.
    اختيار <strong>إلغاء</strong> يعني إلغاء الموعد (يُطلب تأكيد قبل الحفظ).
    @if($appointments->where('status', 'cancelled')->count() > 0)
    <span class="block mt-2" style="color:#dc2626">
        يوجد حجوزات ملغية — إن أُلغيت بالخطأ، اختاري «انتظار» أو «تأكيد» من القائمة لاستعادتها.
    </span>
    @endif
</div>

{{-- Filters --}}
<form method="GET" class="bg-white rounded-2xl p-4 mb-6 flex flex-wrap gap-4 items-end shadow-sm">
    <div>
        <label class="form-label text-xs">الحالة</label>
        <select name="status" class="form-input text-sm" style="padding:0.5rem 0.875rem">
            <option value="">الكل</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>انتظار</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>مكتمل</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغي</option>
        </select>
    </div>
    <div>
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

@push('scripts')
<script>
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
