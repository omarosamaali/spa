@extends('layouts.admin')
@section('title', 'الأجهزة - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <div>
        <h1 class="text-2xl font-black" style="color:#1a1a1a">الأجهزة والغرف</h1>
        <p class="text-sm mt-1" style="color:#888">كل جهاز يُحجز مرة واحدة في الوقت — اربطيه بالخدمات من قسم الخدمات</p>
    </div>
    <button onclick="document.getElementById('addEquipmentModal').classList.remove('hidden')" class="btn-primary">
        إضافة جهاز
    </button>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl text-sm font-bold" style="background:#d1fae5; color:#059669;">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($equipmentList as $eq)
    <div class="bg-white rounded-2xl p-5 shadow-sm" style="border-right:4px solid {{ $eq->is_active ? '#e8b4b8' : '#e5e7eb' }}">
        <div class="font-black text-lg mb-1" style="color:#1a1a1a">{{ $eq->name }}</div>
        @if($eq->category)
        <div class="text-sm mb-2" style="color:#888">{{ $categoryLabels[$eq->category] ?? $eq->category }}</div>
        @endif
        @if($eq->notes)
        <p class="text-sm mb-3" style="color:#666">{{ $eq->notes }}</p>
        @endif
        <span class="text-xs px-2 py-0.5 rounded-full font-bold"
              style="background:{{ $eq->is_active ? '#d1fae5' : '#fee2e2' }}; color:{{ $eq->is_active ? '#059669' : '#dc2626' }}">
            {{ $eq->is_active ? 'نشط' : 'معطّل' }}
        </span>

        <form action="{{ route('admin.equipment.update', $eq) }}" method="POST" class="mt-4 space-y-3 pt-4" style="border-top:1px solid #f5f0f0">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ $eq->name }}" class="form-input text-sm" required>
            <select name="category" class="form-input text-sm">
                <option value="">— قسم —</option>
                @foreach($categoryLabels as $val => $label)
                <option value="{{ $val }}" {{ $eq->category == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <input type="number" name="sort_order" value="{{ $eq->sort_order }}" class="form-input text-sm" min="0" placeholder="ترتيب">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" {{ $eq->is_active ? 'checked' : '' }} style="accent-color:#c9888e">
                نشط
            </label>
            <button type="submit" class="btn-primary w-full text-sm py-2">حفظ</button>
        </form>

        <div class="flex gap-2 mt-2">
            <form action="{{ route('admin.equipment.toggle', $eq) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit" class="w-full py-2 rounded-xl text-xs font-bold" style="background:#fef9c3; color:#d97706">
                    {{ $eq->is_active ? 'إيقاف' : 'تفعيل' }}
                </button>
            </form>
            <form action="{{ route('admin.equipment.destroy', $eq) }}" method="POST"
                  onsubmit="return confirm('حذف {{ addslashes($eq->name) }}؟')">
                @csrf @method('DELETE')
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold" style="background:#fee2e2; color:#dc2626">حذف</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 rounded-2xl bg-white" style="color:#888">
        لا توجد أجهزة — أضيفي جهاز الليزر أو غرفة المساج
    </div>
    @endforelse
</div>

<div id="addEquipmentModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5)">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-xl">
        <h2 class="text-xl font-black mb-6">إضافة جهاز</h2>
        <form action="{{ route('admin.equipment.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">اسم الجهاز *</label>
                <input type="text" name="name" class="form-input" placeholder="مثال: جهاز ليزر ١" required>
            </div>
            <div>
                <label class="form-label">القسم</label>
                <select name="category" class="form-input">
                    <option value="">— عام —</option>
                    @foreach($categoryLabels as $val => $label)
                    <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" rows="2" class="form-input"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary flex-1">إضافة</button>
                <button type="button" onclick="document.getElementById('addEquipmentModal').classList.add('hidden')" class="btn-outline flex-1">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@endsection
