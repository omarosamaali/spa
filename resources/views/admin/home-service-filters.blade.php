@extends('layouts.admin')
@section('title', 'فلتر الخدمات - الرئيسية')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-black mb-1" style="color:#1a1a1a">فلتر «اختاري ما يناسبك»</h1>
    <p class="text-sm" style="color:#888">
        نفس الإعدادات في <a href="{{ route('admin.service-categories') }}" class="font-bold" style="color:#c9888e">تصنيفات الخدمات</a>.
    </p>
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

@include('admin.partials.home-filter-settings', [
    'filterConfig' => $config,
    'filterCategoryLabels' => $categoryLabels,
])

@endsection
