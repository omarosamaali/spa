@extends('layouts.admin')
@section('title', 'آراء العملاء - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <div>
        <h1 class="text-2xl font-black" style="color:#1a1a1a">آراء العملاء</h1>
        <p class="text-sm mt-1" style="color:#888">تظهر في الصفحة الرئيسية — قسم «ثقتكم هي سر نجاحنا». الآراء النشطة فقط تُعرض للزوار.</p>
    </div>
    <button type="button" onclick="document.getElementById('addTestimonialModal').classList.remove('hidden')" class="btn-primary">
        إضافة رأي
    </button>
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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    @forelse($testimonials as $t)
    <div class="bg-white rounded-2xl p-5 shadow-sm" style="border-right:4px solid {{ $t->is_active ? '#e8b4b8' : '#e5e7eb' }}">
        <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center text-white font-black overflow-hidden"
                 style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                @if($t->client_image)
                    <img src="{{ asset('storage/'.$t->client_image) }}" alt="" class="w-full h-full object-cover">
                @else
                    {{ mb_substr($t->client_name, 0, 1) }}
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-black" style="color:#1a1a1a">{{ $t->client_name }}</div>
                @if($t->client_city)
                <div class="text-xs" style="color:#888">{{ $t->client_city }}</div>
                @endif
                <div class="flex gap-0.5 mt-1">
                    @for($i = 0; $i < ($t->rating ?? 5); $i++)
                    <span style="color:#f59e0b">★</span>
                    @endfor
                </div>
            </div>
            <span class="text-xs px-2 py-0.5 rounded-full font-bold flex-shrink-0"
                  style="background:{{ $t->is_active ? '#d1fae5' : '#fee2e2' }}; color:{{ $t->is_active ? '#059669' : '#dc2626' }}">
                {{ $t->is_active ? 'نشط' : 'معطّل' }}
            </span>
        </div>
        <p class="text-sm leading-relaxed mb-4" style="color:#555">«{{ $t->content }}»</p>

        <form action="{{ route('admin.testimonials.update', $t) }}" method="POST" enctype="multipart/form-data" class="space-y-3 pt-4" style="border-top:1px solid #f5f0f0">
            @csrf
            @method('PUT')
            <input type="text" name="client_name" value="{{ old('client_name', $t->client_name) }}" class="form-input text-sm" placeholder="اسم العميلة" required>
            <input type="text" name="client_city" value="{{ old('client_city', $t->client_city) }}" class="form-input text-sm" placeholder="المدينة أو الوصف (اختياري)">
            <textarea name="content" rows="3" class="form-input text-sm" placeholder="نص الرأي" required>{{ old('content', $t->content) }}</textarea>
            <div class="flex gap-3 flex-wrap">
                <div class="flex-1 min-w-[120px]">
                    <label class="text-xs font-bold mb-1 block" style="color:#888">التقييم (1–5)</label>
                    <select name="rating" class="form-input text-sm">
                        @for($r = 5; $r >= 1; $r--)
                        <option value="{{ $r }}" {{ (int) old('rating', $t->rating ?? 5) === $r ? 'selected' : '' }}>{{ $r }} نجوم</option>
                        @endfor
                    </select>
                </div>
                <div class="flex-1 min-w-[140px]">
                    <label class="text-xs font-bold mb-1 block" style="color:#888">صورة (اختياري)</label>
                    <input type="file" name="client_image" accept="image/*" class="form-input text-sm py-1.5">
                </div>
            </div>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1" {{ $t->is_active ? 'checked' : '' }} style="accent-color:#c9888e">
                نشط — يظهر في الموقع
            </label>
            <button type="submit" class="btn-primary w-full text-sm py-2">حفظ التعديلات</button>
        </form>

        <div class="flex gap-2 mt-2">
            <form action="{{ route('admin.testimonials.toggle', $t) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit" class="w-full py-2 rounded-xl text-xs font-bold" style="background:#fef9c3; color:#d97706">
                    {{ $t->is_active ? 'إيقاف' : 'تفعيل' }}
                </button>
            </form>
            <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST"
                  onsubmit="return confirm('حذف رأي {{ addslashes($t->client_name) }}؟')">
                @csrf @method('DELETE')
                <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold" style="background:#fee2e2; color:#dc2626">حذف</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 rounded-2xl bg-white" style="color:#888">
        لا توجد آراء — أضيفي رأياً ليظهر في الصفحة الرئيسية
    </div>
    @endforelse
</div>

<div id="addTestimonialModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.5)">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-black mb-6">إضافة رأي عميلة</h2>
        <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">اسم العميلة *</label>
                <input type="text" name="client_name" value="{{ old('client_name') }}" class="form-input" required>
            </div>
            <div>
                <label class="form-label">المدينة / الوصف</label>
                <input type="text" name="client_city" value="{{ old('client_city') }}" class="form-input" placeholder="مثال: بغداد — أو المديرة">
            </div>
            <div>
                <label class="form-label">نص الرأي *</label>
                <textarea name="content" rows="4" class="form-input" required placeholder="خدمة ممتازة ونتائج رائعة...">{{ old('content') }}</textarea>
            </div>
            <div>
                <label class="form-label">التقييم</label>
                <select name="rating" class="form-input">
                    @for($r = 5; $r >= 1; $r--)
                    <option value="{{ $r }}" {{ (int) old('rating', 5) === $r ? 'selected' : '' }}>{{ $r }} نجوم</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="form-label">صورة (اختياري)</label>
                <input type="file" name="client_image" accept="image/*" class="form-input py-1.5">
            </div>
            <label class="flex items-center gap-2 text-sm font-bold">
                <input type="checkbox" name="is_active" value="1" checked style="accent-color:#c9888e">
                نشط — يظهر فوراً في الموقع
            </label>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">إضافة</button>
                <button type="button" class="flex-1 py-3 rounded-xl font-bold" style="background:#f5f0f0; color:#666"
                        onclick="document.getElementById('addTestimonialModal').classList.add('hidden')">إلغاء</button>
            </div>
        </form>
    </div>
</div>

@endsection
