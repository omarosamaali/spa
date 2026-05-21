@extends('layouts.admin')
@section('title', 'فيديو الصفحة الرئيسية')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">فيديو الهيرو (الصفحة الرئيسية)</h1>
    <p class="text-sm" style="color:#888">عدّل الفيديو الذي يظهر في أول سلايد بالصفحة الرئيسية</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Form --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <form action="{{ route('admin.hero-video.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">رابط الفيديو (MP4)</label>
                <input type="url" name="hero_video_url" value="{{ old('hero_video_url', $settings['url']) }}"
                       class="form-input" dir="ltr" placeholder="https://example.com/video.mp4">
                <p class="text-xs mt-1" style="color:#888">يمكنك لصق رابط من Pexels أو أي استضافة فيديو</p>
                @error('hero_video_url')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">رابط فيديو احتياطي (اختياري)</label>
                <input type="url" name="hero_video_url_alt" value="{{ old('hero_video_url_alt', $settings['url_alt']) }}"
                       class="form-input" dir="ltr" placeholder="https://example.com/video-backup.mp4">
                @error('hero_video_url_alt')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label">صورة الغلاف (Poster)</label>
                <input type="url" name="hero_video_poster" value="{{ old('hero_video_poster', $settings['poster']) }}"
                       class="form-input" dir="ltr" placeholder="https://example.com/poster.jpg">
                @error('hero_video_poster')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
            </div>

            <div style="border-top:2px solid #f5f0f0; padding-top:1.25rem">
                <label class="form-label">أو ارفعي فيديو من الجهاز</label>
                <input type="file" name="hero_video_file" accept="video/mp4,video/webm"
                       class="form-input" style="padding:0.5rem">
                <p class="text-xs mt-1" style="color:#888">MP4 أو WebM — حتى 50 ميغابايت. الملف المرفوع له أولوية على الرابط.</p>
                @error('hero_video_file')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror

                @if($settings['path'])
                <div class="mt-3 p-3 rounded-xl flex items-center justify-between" style="background:#f0fdf4; border:1px solid #bbf7d0">
                    <span class="text-sm font-bold" style="color:#059669">✓ يوجد فيديو مرفوع على السيرفر</span>
                    <label class="flex items-center gap-2 text-sm cursor-pointer" style="color:#dc2626">
                        <input type="checkbox" name="remove_uploaded" value="1">
                        حذف الملف
                    </label>
                </div>
                @endif
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                حفظ التغييرات
            </button>
        </form>
    </div>

    {{-- Preview --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="font-black mb-4" style="color:#1a1a1a">معاينة الفيديو الحالي</h2>
        <div class="rounded-xl overflow-hidden" style="background:#1a1a1a; aspect-ratio:16/9">
            <video controls muted playsinline class="w-full h-full object-cover"
                   poster="{{ $hero['poster'] }}">
                <source src="{{ $hero['src'] }}" type="video/mp4">
                @if($hero['src_alt'])
                <source src="{{ $hero['src_alt'] }}" type="video/mp4">
                @endif
            </video>
        </div>
        <p class="text-xs mt-3 break-all" style="color:#888" dir="ltr">{{ $hero['src'] }}</p>
        <a href="{{ route('home') }}" target="_blank"
           class="inline-flex items-center gap-2 mt-4 text-sm font-bold no-underline" style="color:#c9888e">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            عرض الصفحة الرئيسية
        </a>
    </div>

</div>

@endsection
