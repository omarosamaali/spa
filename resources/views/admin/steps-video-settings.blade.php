@extends('layouts.admin')
@section('title', 'فيديو الخطوات - NAY SPA')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">فيديو الخطوات</h1>
    <p class="text-sm" style="color:#888">يظهر على يسار قسم «احجزي في 4 خطوات سهلة» في الصفحة الرئيسية</p>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-xl font-bold text-sm" style="background:#d1fae5; color:#059669">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.steps-video.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">معاينة</h2>
        @if($stepsVideo['has_video'] ?? false)
        <div class="max-w-sm mx-auto rounded-2xl overflow-hidden" style="border:1px solid #e5e7eb; background:#1a1a1a;">
            @include('partials.steps-video-player', ['stepsVideo' => $stepsVideo])
        </div>
        @else
        <div class="p-8 rounded-xl text-center text-sm" style="background:#f9f5f5; color:#888">
            لا يوجد فيديو حالياً — أضيفي رابطاً أو ارفعي ملفاً بالأسفل.
        </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">رابط الفيديو</h2>
        <p class="text-sm" style="color:#888">رابط مباشر لملف MP4، أو رابط YouTube / Vimeo</p>
        <input type="url" name="steps_video_url" value="{{ old('steps_video_url', $settings['steps_video_url']) }}"
               class="form-input" dir="ltr" placeholder="https://...">
        @error('steps_video_url')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-5">
        <h2 class="text-lg font-black" style="color:#1a1a1a">رفع فيديو من الجهاز</h2>
        <p class="text-sm" style="color:#888">MP4 أو WebM أو MOV — حتى 50 ميجابايت. إذا رفعتِ ملفاً يُستخدم بدلاً من الرابط.</p>

        @if(!empty($settings['steps_video_path']))
        <div class="p-3 rounded-xl text-sm" style="background:#f0fdf4; color:#059669">
            ✓ يوجد فيديو مرفوع على السيرفر
        </div>
        <label class="flex items-center gap-2 text-sm cursor-pointer" style="color:#dc2626">
            <input type="checkbox" name="remove_steps_video" value="1"> حذف الفيديو المرفوع
        </label>
        @endif

        <input type="file" name="steps_video_file" accept="video/mp4,video/webm,video/quicktime"
               class="form-input" style="padding:0.5rem">
        @error('steps_video_file')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-black" style="color:#1a1a1a">صورة الغلاف (اختياري)</h2>
        <p class="text-sm" style="color:#888">تظهر قبل تشغيل الفيديو إذا كان الملف MP4 مباشراً</p>
        <input type="url" name="steps_video_poster" value="{{ old('steps_video_poster', $settings['steps_video_poster']) }}"
               class="form-input" dir="ltr" placeholder="https://...jpg">
        @error('steps_video_poster')<p class="text-xs mt-1" style="color:#dc2626">{{ $message }}</p>@enderror
    </div>

    <button type="submit" class="btn-primary">حفظ فيديو الخطوات</button>
</form>

@endsection
