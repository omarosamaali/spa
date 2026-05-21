@extends('layouts.admin')
@section('title', 'سلايدر الصفحة الرئيسية')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">سلايدر الصفحة الرئيسية</h1>
    <p class="text-sm" style="color:#888">عدّل صور وفيديوهات ونصوص كل شرائح الهيرو ({{ $slides->count() }} شرائح)</p>
</div>

<form action="{{ route('admin.hero-slides.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    @foreach($slides as $slide)
    <div class="bg-white rounded-2xl p-6 shadow-sm" style="border-right:4px solid {{ $slide->is_active ? '#e8b4b8' : '#e5e7eb' }}">
        <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
            <h2 class="text-lg font-black" style="color:#1a1a1a">
                شريحة {{ $slide->sort_order }}
                <span class="text-sm font-bold mr-2 px-2 py-0.5 rounded-full"
                      style="background:{{ $slide->type === 'video' ? '#dbeafe' : '#fce7f3' }}; color:{{ $slide->type === 'video' ? '#2563eb' : '#c9888e' }}">
                    {{ $slide->type === 'video' ? 'فيديو' : 'صورة' }}
                </span>
            </h2>
            <label class="flex items-center gap-2 text-sm font-bold cursor-pointer" style="color:#059669">
                <input type="checkbox" name="slides[{{ $slide->id }}][is_active]" value="1" {{ $slide->is_active ? 'checked' : '' }}>
                نشط (يظهر في الموقع)
            </label>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Media --}}
            <div class="space-y-4">
                <div>
                    <label class="form-label">نوع الشريحة</label>
                    <select name="slides[{{ $slide->id }}][type]" class="form-input">
                        <option value="image" {{ $slide->type === 'image' ? 'selected' : '' }}>صورة</option>
                        <option value="video" {{ $slide->type === 'video' ? 'selected' : '' }}>فيديو</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">{{ $slide->type === 'video' ? 'رابط الفيديو (MP4)' : 'رابط الصورة' }}</label>
                    <input type="url" name="slides[{{ $slide->id }}][media_url]" value="{{ $slide->media_url }}"
                           class="form-input" dir="ltr" placeholder="https://...">
                </div>

                @if($slide->type === 'video')
                <div>
                    <label class="form-label">رابط فيديو احتياطي (اختياري)</label>
                    <input type="url" name="slides[{{ $slide->id }}][media_url_alt]" value="{{ $slide->media_url_alt }}"
                           class="form-input" dir="ltr">
                </div>
                <div>
                    <label class="form-label">صورة الغلاف (Poster)</label>
                    <input type="url" name="slides[{{ $slide->id }}][poster_url]" value="{{ $slide->poster_url }}"
                           class="form-input" dir="ltr">
                </div>
                @endif

                <div>
                    <label class="form-label">أو ارفع ملف من الجهاز</label>
                    <input type="file" name="slides[{{ $slide->id }}][media_file]"
                           accept="{{ $slide->type === 'video' ? 'video/mp4,video/webm' : 'image/jpeg,image/png,image/webp' }}"
                           class="form-input" style="padding:0.5rem">
                    <p class="text-xs mt-1" style="color:#888">{{ $slide->type === 'video' ? 'MP4/WebM حتى 50MB' : 'JPG/PNG/WebP حتى 2MB' }}</p>
                </div>

                @if($slide->type === 'video')
                <div>
                    <label class="form-label">رفع صورة غلاف (اختياري)</label>
                    <input type="file" name="slides[{{ $slide->id }}][poster_file]" accept="image/*"
                           class="form-input" style="padding:0.5rem">
                </div>
                @endif

                @if($slide->media_path)
                <label class="flex items-center gap-2 text-sm" style="color:#dc2626">
                    <input type="checkbox" name="slides[{{ $slide->id }}][remove_media]" value="1">
                    حذف الملف المرفوع
                </label>
                @endif
            </div>

            {{-- Preview + Text --}}
            <div class="space-y-4">
                <div class="rounded-xl overflow-hidden" style="background:#1a1a1a; aspect-ratio:16/9">
                    @if($slide->isVideo())
                    <video controls muted class="w-full h-full object-cover" poster="{{ $slide->posterSrc() }}">
                        <source src="{{ $slide->mediaSrc() }}" type="video/mp4">
                    </video>
                    @else
                    <img src="{{ $slide->mediaSrc() }}" alt="" class="w-full h-full object-cover">
                    @endif
                </div>

                <div>
                    <label class="form-label">الشارة (Badge)</label>
                    <input type="text" name="slides[{{ $slide->id }}][badge]" value="{{ $slide->badge }}" class="form-input">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">العنوان</label>
                        <input type="text" name="slides[{{ $slide->id }}][title]" value="{{ $slide->title }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">الجزء الملوّن</label>
                        <input type="text" name="slides[{{ $slide->id }}][title_highlight]" value="{{ $slide->title_highlight }}" class="form-input">
                    </div>
                </div>
                <div>
                    <label class="form-label">الوصف</label>
                    <input type="text" name="slides[{{ $slide->id }}][subtitle]" value="{{ $slide->subtitle }}" class="form-input">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">زر 1 — النص</label>
                        <input type="text" name="slides[{{ $slide->id }}][btn_primary_text]" value="{{ $slide->btn_primary_text }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">زر 1 — الرابط</label>
                        <input type="text" name="slides[{{ $slide->id }}][btn_primary_url]" value="{{ $slide->btn_primary_url }}" class="form-input" dir="ltr" placeholder="/booking">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">زر 2 — النص</label>
                        <input type="text" name="slides[{{ $slide->id }}][btn_secondary_text]" value="{{ $slide->btn_secondary_text }}" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">زر 2 — الرابط</label>
                        <input type="text" name="slides[{{ $slide->id }}][btn_secondary_url]" value="{{ $slide->btn_secondary_url }}" class="form-input" dir="ltr">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <button type="submit" class="btn-primary px-10 py-3 text-base">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        حفظ كل الشرائح
    </button>
</form>

<div class="mt-6">
    <a href="{{ route('home') }}" target="_blank" class="text-sm font-bold no-underline" style="color:#c9888e">← معاينة الصفحة الرئيسية</a>
</div>

@endsection
