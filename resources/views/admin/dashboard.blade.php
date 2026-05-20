@extends('layouts.admin')

@section('title', 'لوحة التحكم - NAY SPA')

@section('content')

<div class="mb-8 flex items-center justify-between flex-wrap gap-4">
    <div>
        <h1 class="text-2xl font-black" style="color:#1a1a1a">لوحة التحكم</h1>
        <p class="text-sm mt-1" style="color:#888">{{ now()->translatedFormat('l، d F Y') }}</p>
    </div>
</div>

{{-- Stats cards --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
    $statCards = [
        ['label'=>'إجمالي الحجوزات','val'=>$stats['total'],'color'=>'#e8b4b8','bg'=>'#fdf0f2',
         'svg'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>'],
        ['label'=>'انتظار التأكيد','val'=>$stats['pending'],'color'=>'#d97706','bg'=>'#fef9c3',
         'svg'=>'<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
        ['label'=>'مؤكدة','val'=>$stats['confirmed'],'color'=>'#059669','bg'=>'#d1fae5',
         'svg'=>'<path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
        ['label'=>'موعد اليوم','val'=>$stats['today'],'color'=>'#7c3aed','bg'=>'#ede9fe',
         'svg'=>'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><circle cx="12" cy="16" r="2"/>'],
        ['label'=>'رسائل جديدة','val'=>$stats['unread_contacts'],'color'=>'#0284c7','bg'=>'#e0f2fe',
         'svg'=>'<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
         'route'=>'admin.contacts'],
    ];
    @endphp

    @foreach($statCards as $card)
    <div class="bg-white rounded-2xl p-5 shadow-sm transition-all hover:shadow-md {{ isset($card['route']) ? 'cursor-pointer' : '' }}"
         style="border-right:4px solid {{ $card['color'] }}"
         @if(isset($card['route'])) onclick="window.location='{{ route($card['route']) }}'" @endif>
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                 style="background:{{ $card['bg'] }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="{{ $card['color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    {!! $card['svg'] !!}
                </svg>
            </div>
            <div class="text-3xl font-black" style="color:{{ $card['color'] }}">{{ $card['val'] }}</div>
        </div>
        <div class="text-sm font-bold" style="color:#555">{{ $card['label'] }}</div>
    </div>
    @endforeach
</div>

{{-- Recent bookings + Messages --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Recent bookings (2/3 width) --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #f0e8e9">
            <h2 class="font-black text-lg" style="color:#1a1a1a">آخر الحجوزات</h2>
            <a href="{{ route('admin.appointments') }}" class="text-sm font-bold flex items-center gap-1" style="color:#c9888e">
                عرض الكل
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead style="background:#fdf8f5">
                    <tr>
                        <th class="p-3 text-right font-bold" style="color:#555">#</th>
                        <th class="p-3 text-right font-bold" style="color:#555">العميلة</th>
                        <th class="p-3 text-right font-bold" style="color:#555">الخدمة</th>
                        <th class="p-3 text-right font-bold" style="color:#555">التاريخ</th>
                        <th class="p-3 text-right font-bold" style="color:#555">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent as $a)
                    <tr style="border-top:1px solid #f5f0f0">
                        <td class="p-3" style="color:#aaa">#{{ str_pad($a->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-3">
                            <div class="font-bold" style="color:#1a1a1a">{{ $a->client_name }}</div>
                            <div class="text-xs" style="color:#888; direction:ltr">{{ $a->client_phone }}</div>
                        </td>
                        <td class="p-3 font-bold" style="color:#444">{{ $a->service->name ?? '—' }}</td>
                        <td class="p-3">
                            <div style="color:#444">{{ $a->appointment_date->format('Y/m/d') }}</div>
                            <div class="text-xs" style="color:#888">{{ substr($a->appointment_time, 0, 5) }}</div>
                        </td>
                        <td class="p-3">
                            @php
                            $sc = [
                                'pending'   => ['bg'=>'#fef9c3','color'=>'#ca8a04','label'=>'انتظار'],
                                'confirmed' => ['bg'=>'#d1fae5','color'=>'#059669','label'=>'مؤكد'],
                                'cancelled' => ['bg'=>'#fee2e2','color'=>'#dc2626','label'=>'ملغي'],
                                'completed' => ['bg'=>'#dbeafe','color'=>'#2563eb','label'=>'مكتمل'],
                            ][$a->status] ?? ['bg'=>'#f3f4f6','color'=>'#666','label'=>$a->status];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold"
                                  style="background:{{ $sc['bg'] }}; color:{{ $sc['color'] }}">
                                {{ $sc['label'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-10 text-center" style="color:#ccc">لا توجد حجوزات بعد</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Latest messages (1/3 width) --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 flex items-center justify-between" style="border-bottom:1px solid #f0e8e9">
            <h2 class="font-black text-lg" style="color:#1a1a1a">آخر الرسائل</h2>
            <a href="{{ route('admin.contacts') }}" class="text-sm font-bold flex items-center gap-1" style="color:#c9888e">
                عرض الكل
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        <div>
            @forelse($messages as $msg)
            <div class="p-4 transition-all hover:bg-gray-50 {{ $loop->last ? '' : 'border-b' }}"
                 style="{{ $loop->last ? '' : 'border-color:#f5f0f0' }}; background:{{ !$msg->is_read ? '#fffbf5' : 'white' }}">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-black text-sm flex-shrink-0"
                         style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                        {{ mb_substr($msg->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-sm truncate" style="color:#1a1a1a">{{ $msg->name }}</span>
                            @if(!$msg->is_read)
                            <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#e8b4b8"></span>
                            @endif
                        </div>
                        <p class="text-xs mt-0.5 truncate" style="color:#888">{{ $msg->subject }}</p>
                        <p class="text-xs mt-1 line-clamp-2" style="color:#aaa">{{ Str::limit($msg->message, 60) }}</p>
                        <span class="text-xs mt-1 block" style="color:#ccc">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-12 text-center" style="color:#ccc">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-2" style="opacity:0.4"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <p class="text-sm font-bold">لا توجد رسائل</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
