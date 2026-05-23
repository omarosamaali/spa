@extends('layouts.admin')
@section('title', 'الأخصائيات - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <div>
        <h1 class="text-2xl font-black" style="color:#1a1a1a">الأخصائيات</h1>
        <p class="text-sm mt-1" style="color:#888">إدارة قائمة الأخصائيات في نموذج الحجز وصفحة عن المركز</p>
    </div>
    <button onclick="document.getElementById('addStaffModal').classList.remove('hidden')"
            class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        إضافة أخصائية
    </button>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl text-sm font-bold" style="background:#d1fae5; color:#059669; border:1px solid #a7f3d0;">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($staffMembers as $member)
    <div class="bg-white rounded-2xl p-5 shadow-sm transition-all hover:shadow-md"
         style="border-right:4px solid {{ $member->is_active ? '#e8b4b8' : '#e5e7eb' }}">

        <div class="flex items-start gap-4 mb-4">
            @if($member->image)
            <img src="{{ asset('storage/'.$member->image) }}" alt=""
                 class="w-14 h-14 rounded-xl object-cover flex-shrink-0">
            @else
            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 text-xl font-black text-white"
                 style="background:linear-gradient(135deg,#e8b4b8,#c9888e);">
                {{ mb_substr($member->name, 0, 1) }}
            </div>
            @endif
            <div class="flex-1 min-w-0">
                <div class="font-black truncate" style="color:#1a1a1a">{{ $member->name }}</div>
                @if($member->role)
                <div class="text-sm mt-0.5" style="color:#888">{{ $member->role }}</div>
                @endif
                <span class="inline-block mt-2 text-xs px-2 py-0.5 rounded-full font-bold"
                      style="background:{{ $member->is_active ? '#d1fae5' : '#fee2e2' }}; color:{{ $member->is_active ? '#059669' : '#dc2626' }}">
                    {{ $member->is_active ? 'نشطة — تظهر في الحجز' : 'معطلة' }}
                </span>
            </div>
        </div>

        @if($member->bio)
        <p class="text-sm mb-4 leading-relaxed line-clamp-2" style="color:#666">{{ $member->bio }}</p>
        @endif

        <div class="flex items-center gap-2 pt-3" style="border-top:1px solid #f5f0f0">
            <a href="{{ route('admin.staff.edit', $member) }}"
               class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-xl text-xs font-bold"
               style="background:#dbeafe; color:#2563eb">
                تعديل
            </a>

            <form action="{{ route('admin.staff.toggle', $member) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="px-3 py-2 rounded-xl text-xs font-bold"
                        style="background:{{ $member->is_active ? '#fef9c3' : '#d1fae5' }}; color:{{ $member->is_active ? '#d97706' : '#059669' }}">
                    {{ $member->is_active ? 'إيقاف' : 'تفعيل' }}
                </button>
            </form>

            <form action="{{ route('admin.staff.destroy', $member) }}" method="POST"
                  onsubmit="return confirm('هل تريد حذف {{ addslashes($member->name) }}؟')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-3 py-2 rounded-xl text-xs font-bold"
                        style="background:#fee2e2; color:#dc2626">
                    حذف
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-2xl p-12 text-center" style="color:#888">
        <p class="font-bold mb-2">لا توجد أخصائيات بعد</p>
        <p class="text-sm">اضغط «إضافة أخصائية» لإظهارها في نموذج الحجز</p>
    </div>
    @endforelse
</div>

{{-- Add Staff Modal --}}
<div id="addStaffModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background:rgba(0,0,0,0.6); backdrop-filter:blur(4px)">
    <div class="bg-white rounded-3xl p-8 w-full shadow-2xl overflow-y-auto" style="max-width:520px; max-height:90vh">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-black" style="color:#1a1a1a">إضافة أخصائية</h2>
            <button type="button" onclick="document.getElementById('addStaffModal').classList.add('hidden')"
                    class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:#f5f5f5; color:#888">×</button>
        </div>

        <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="form-label">الاسم <span style="color:#c9888e">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input @error('name') border-red-400 @enderror" required
                       placeholder="مثال: د. سارة أحمد">
                @error('name')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">التخصص / المسمى</label>
                <input type="text" name="role" value="{{ old('role') }}" class="form-input"
                       placeholder="مثال: أخصائية الليزر والبشرة">
            </div>

            <div>
                <label class="form-label">نبذة قصيرة (اختياري)</label>
                <textarea name="bio" rows="3" class="form-input" placeholder="تظهر في صفحة عن المركز">{{ old('bio') }}</textarea>
            </div>

            <div>
                <label class="form-label">صورة (اختياري)</label>
                <input type="file" name="image" accept="image/*" class="form-input" style="padding:0.5rem">
            </div>

            <div class="flex items-center gap-3 py-3 px-4 rounded-xl" style="background:#f9f5f5">
                <input type="checkbox" name="is_active" id="new_staff_active" value="1"
                       class="w-5 h-5 rounded" style="accent-color:#c9888e" checked>
                <label for="new_staff_active" class="font-bold cursor-pointer" style="color:#1a1a1a">نشطة (تظهر في الحجز)</label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1 justify-center">إضافة</button>
                <button type="button" onclick="document.getElementById('addStaffModal').classList.add('hidden')"
                        class="btn-outline" style="color:#555; border-color:#ddd">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('addStaffModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });
    @if($errors->any() && old('name') !== null)
    document.getElementById('addStaffModal').classList.remove('hidden');
    @endif
</script>
@endpush

@endsection
