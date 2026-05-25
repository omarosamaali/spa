@extends('layouts.app')
@section('title', 'عن المركز - NAY SPA')
@section('content')

<div class="page-header">
    <div class="badge-spa mb-4 inline-flex" style="background:rgba(232,180,184,0.15); color:#e8b4b8; border-color:rgba(232,180,184,0.3)">قصتنا</div>
    <h1 class="text-4xl font-black text-white mb-3">عن المركز</h1>
    <p style="color:rgba(255,255,255,0.65)">نحن نؤمن أن كل عميلة تستحق أفضل عناية</p>
</div>

<section class="py-20" style="background:#1a1a1a">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Who We Are --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-20">
        <div>
            <div class="badge-spa mb-4">{{ $aboutWho['badge'] }}</div>
            <h2 class="text-3xl font-black mb-4 text-white">{!! nl2br(e($aboutWho['title'])) !!}</h2>
            <p class="leading-loose mb-4" style="color:rgba(255,255,255,0.6)">{{ $aboutWho['text_1'] }}</p>
            @if($aboutWho['text_2'])
            <p class="leading-loose" style="color:rgba(255,255,255,0.6)">{{ $aboutWho['text_2'] }}</p>
            @endif
            <div class="flex flex-wrap gap-3 mt-8">
                <a href="{{ route('booking') }}" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    احجزي موعدك
                </a>
                <a href="{{ route('contact') }}" class="btn-outline" style="color:#e8b4b8; border-color:rgba(232,180,184,0.5)">
                    تواصلي معنا
                </a>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden relative" style="height:380px; background:linear-gradient(135deg,#3d2b2e,#1a1a1a)">
            @if($aboutWho['has_image'])
            <img src="{{ $aboutWho['image_url'] }}" alt="{{ $aboutWho['badge'] }}"
                 class="w-full h-full object-cover">
            @else
            <div class="absolute inset-0" style="background:radial-gradient(ellipse at 40% 40%, rgba(232,180,184,0.2) 0%, transparent 60%)"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center text-white">
                    <svg width="80" height="80" viewBox="0 0 120 120" fill="none" class="mx-auto mb-4" style="opacity:0.7">
                        <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#abt1)" opacity="0.9"/>
                        <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#abt2)" opacity="0.7" transform="rotate(90 60 60)"/>
                        <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#abt1)" opacity="0.6" transform="rotate(45 60 60)"/>
                        <ellipse cx="60" cy="45" rx="14" ry="28" fill="url(#abt2)" opacity="0.6" transform="rotate(135 60 60)"/>
                        <circle cx="60" cy="60" r="16" fill="url(#abtc)"/>
                        <defs>
                            <linearGradient id="abt1" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#f5dfe1"/>
                                <stop offset="100%" stop-color="#c9888e" stop-opacity="0.6"/>
                            </linearGradient>
                            <linearGradient id="abt2" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#c9a96e"/>
                                <stop offset="100%" stop-color="#e8b4b8" stop-opacity="0.5"/>
                            </linearGradient>
                            <radialGradient id="abtc" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#e8b4b8"/>
                                <stop offset="100%" stop-color="#c9888e"/>
                            </radialGradient>
                        </defs>
                    </svg>
                    <div class="font-black text-2xl tracking-widest" style="color:white">NAY SPA</div>
                    <div class="text-sm mt-1" style="color:rgba(255,255,255,0.5); letter-spacing:3px">BEAUTY & SPA</div>
                </div>
            </div>
            @endif
            <div class="absolute top-5 right-5 w-10 h-10 pointer-events-none" style="border-top:2px solid rgba(201,169,110,0.4); border-right:2px solid rgba(201,169,110,0.4); border-radius:0 6px 0 0"></div>
            <div class="absolute bottom-5 left-5 w-10 h-10 pointer-events-none" style="border-bottom:2px solid rgba(201,169,110,0.4); border-left:2px solid rgba(201,169,110,0.4); border-radius:0 0 0 6px"></div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-20">
        @foreach([
            ['val'=> ($stats['clients'] > 0 ? '+'.$stats['clients'] : '+500'), 'label'=>'عميلة راضية'],
            ['val'=> $stats['years'].'+',                                        'label'=>'سنوات خبرة'],
            ['val'=> ($stats['services'] > 0 ? $stats['services'].'+' : '15+'), 'label'=>'خدمة متخصصة'],
            ['val'=> $stats['rating'].'%',                                       'label'=>'ضمان الرضا'],
        ] as $s)
        <div class="text-center p-6 rounded-2xl" style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.1)">
            <div class="text-3xl font-black mb-2" style="color:#e8b4b8">{{ $s['val'] }}</div>
            <div class="text-sm" style="color:rgba(255,255,255,0.5)">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Team Section --}}
    @if($staff->isNotEmpty())
    <div class="mb-20">
        <div class="text-center mb-12">
            <div class="badge-spa mb-4">فريقنا</div>
            <h2 class="text-3xl font-black mb-4 text-white">خبيراتنا المتميزات</h2>
            <div class="section-divider mb-4"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($staff as $member)
            <div class="rounded-2xl p-6 text-center transition-all hover:-translate-y-1"
                 style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.1)">
                <div class="w-20 h-20 rounded-full mx-auto mb-4 flex items-center justify-center text-white font-black text-2xl overflow-hidden"
                     style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                    @if($member->image)
                        <img src="{{ asset('storage/'.$member->image) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                    @else
                        {{ mb_substr($member->name, 0, 1) }}
                    @endif
                </div>
                <h3 class="font-black mb-1 text-white">{{ $member->name }}</h3>
                @if($member->role)
                <p class="text-sm mb-3" style="color:#e8b4b8">{{ $member->role }}</p>
                @endif
                @if($member->bio)
                <p class="text-xs leading-relaxed" style="color:rgba(255,255,255,0.5)">{{ $member->bio }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Why Choose Us --}}
    <div>
        <div class="text-center mb-12">
            <div class="badge-spa mb-4">لماذا نحن</div>
            <h2 class="text-3xl font-black mb-4 text-white">ما يميزنا عن غيرنا</h2>
            <div class="section-divider mb-4"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach([
                ['title'=>'تقنيات حديثة','desc'=>'نستخدم أحدث الأجهزة والتقنيات المعتمدة عالمياً','svg'=>'<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>'],
                ['title'=>'منتجات عالمية','desc'=>'أفضل المنتجات المستوردة من أشهر الماركات العالمية','svg'=>'<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>'],
                ['title'=>'بيئة آمنة ومعقمة','desc'=>'أعلى معايير النظافة والتعقيم لضمان سلامتك','svg'=>'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
                ['title'=>'فريق متخصص','desc'=>'خبيرات حاصلات على شهادات ودورات تدريبية متخصصة','svg'=>'<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>'],
            ] as $feat)
            <div class="flex items-start gap-4 rounded-2xl p-5"
                 style="background:#2a2a2a; border:1px solid rgba(232,180,184,0.08)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background:rgba(232,180,184,0.1)">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#e8b4b8" stroke-width="2" stroke-linecap="round">
                        {!! $feat['svg'] !!}
                    </svg>
                </div>
                <div>
                    <h3 class="font-black mb-1 text-white">{{ $feat['title'] }}</h3>
                    <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.5)">{{ $feat['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
</section>

@endsection
