@extends('layouts.admin')
@section('title', 'رسائل التواصل - NAY SPA')

@section('content')

<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    <div>
        <h1 class="text-2xl font-black" style="color:#1a1a1a">رسائل التواصل</h1>
        @if($unreadCount > 0)
        <p class="text-sm mt-1" style="color:#888">{{ $unreadCount }} رسالة غير مقروءة</p>
        @endif
    </div>
    <div class="flex items-center gap-3">
        {{-- Filter --}}
        <div class="flex rounded-xl overflow-hidden" style="border:1px solid #e5e7eb">
            <a href="{{ route('admin.contacts') }}"
               class="px-4 py-2 text-sm font-bold transition-all"
               style="background:{{ !request('filter') ? '#1a1a1a' : 'white' }}; color:{{ !request('filter') ? 'white' : '#555' }}">
               الكل
            </a>
            <a href="{{ route('admin.contacts', ['filter'=>'unread']) }}"
               class="px-4 py-2 text-sm font-bold transition-all"
               style="background:{{ request('filter')==='unread' ? '#1a1a1a' : 'white' }}; color:{{ request('filter')==='unread' ? 'white' : '#555' }}">
               غير مقروءة
            </a>
            <a href="{{ route('admin.contacts', ['filter'=>'read']) }}"
               class="px-4 py-2 text-sm font-bold transition-all"
               style="background:{{ request('filter')==='read' ? '#1a1a1a' : 'white' }}; color:{{ request('filter')==='read' ? 'white' : '#555' }}">
               مقروءة
            </a>
        </div>
        @if($unreadCount > 0)
        <form action="{{ route('admin.contacts.markAllRead') }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-4 py-2 rounded-xl text-sm font-bold transition-all hover:opacity-80"
                    style="background:#d1fae5; color:#059669">
                تحديد الكل كمقروء
            </button>
        </form>
        @endif
    </div>
</div>

{{-- Messages Table --}}
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    @forelse($messages as $msg)
    <div class="p-5 transition-all hover:bg-gray-50 {{ $loop->last ? '' : 'border-b' }}"
         style="{{ $loop->last ? '' : 'border-color:#f5f0f0' }}; background:{{ !$msg->is_read ? '#fffbf5' : 'white' }}">

        <div class="flex items-start justify-between gap-4">
            {{-- Avatar + Info --}}
            <div class="flex items-start gap-4 flex-1 min-w-0">
                <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-black text-base flex-shrink-0"
                     style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                    {{ mb_substr($msg->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="font-black" style="color:#1a1a1a">{{ $msg->name }}</span>
                        @if(!$msg->is_read)
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold" style="background:#fef3c7; color:#d97706">جديدة</span>
                        @endif
                        <span class="text-xs px-2 py-0.5 rounded-full font-bold" style="background:#f5dfe1; color:#c9888e">{{ $msg->subject }}</span>
                    </div>
                    <div class="flex items-center gap-4 mt-1 flex-wrap">
                        <span class="text-sm" style="color:#888; direction:ltr">{{ $msg->phone }}</span>
                        @if($msg->email)
                        <span class="text-sm" style="color:#888; direction:ltr">{{ $msg->email }}</span>
                        @endif
                        <span class="text-xs" style="color:#aaa">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    {{-- Message body (collapsed) --}}
                    <p class="text-sm mt-2 leading-relaxed" style="color:#555">{{ $msg->message }}</p>
                </div>
            </div>

            {{-- Actions --}}
            @php
                $waPhone = preg_replace('/\D/', '', $msg->phone);
                if (str_starts_with($waPhone, '0')) {
                    $waPhone = '964' . ltrim($waPhone, '0');
                } elseif (!str_starts_with($waPhone, '964')) {
                    $waPhone = '964' . $waPhone;
                }
                $waText = "مرحباً {$msg->name}،\nبخصوص: {$msg->subject}\n\n{$msg->message}";
                $waUrl = 'https://wa.me/' . $waPhone . '?text=' . rawurlencode($waText);
                $gmailUrl = $msg->email
                    ? 'https://mail.google.com/mail/?view=cm&fs=1&to=' . rawurlencode($msg->email)
                      . '&su=' . rawurlencode('رد: ' . $msg->subject)
                      . '&body=' . rawurlencode("مرحباً {$msg->name},\n\n")
                    : null;
            @endphp
            <div class="flex items-center gap-2 flex-shrink-0">
                @if(!$msg->is_read)
                <form action="{{ route('admin.contacts.read', $msg) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" title="تحديد كمقروءة"
                            class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:opacity-80"
                            style="background:#d1fae5; color:#059669">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </button>
                </form>
                @endif
                <a href="tel:{{ $msg->phone }}" title="اتصال"
                   class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:opacity-80 no-underline"
                   style="background:#dbeafe; color:#2563eb">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.8 19.79 19.79 0 01.22 2.18 2 2 0 012.22 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/></svg>
                </a>
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" title="رد عبر واتساب"
                   class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:opacity-80 no-underline"
                   style="background:#dcfce7; color:#16a34a">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.095.541 4.063 1.49 5.776L0 24l6.385-1.474A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.853 0-3.584-.504-5.074-1.38l-.361-.214-3.741.863.933-3.638-.235-.374A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                </a>
                @if($gmailUrl)
                <a href="{{ $gmailUrl }}" target="_blank" rel="noopener noreferrer" title="رد عبر البريد (Gmail)"
                   class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:opacity-80 no-underline"
                   style="background:#f3e8ff; color:#7c3aed">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </a>
                @endif
                <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST"
                      onsubmit="return confirm('هل تريد حذف هذه الرسالة؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="حذف"
                            class="w-8 h-8 rounded-lg flex items-center justify-center transition-all hover:opacity-80"
                            style="background:#fee2e2; color:#dc2626">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="py-16 text-center" style="color:#aaa">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mx-auto mb-3" style="opacity:0.3"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <p class="font-bold">لا توجد رسائل بعد</p>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($messages->hasPages())
<div class="mt-6 flex justify-center">
    {{ $messages->appends(request()->query())->links() }}
</div>
@endif

@endsection
