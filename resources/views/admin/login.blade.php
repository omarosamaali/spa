<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - NAY SPA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body style="background:linear-gradient(135deg,#1a1a1a 0%,#3d2b2e 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:1rem">

<div style="width:100%; max-width:440px">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center gap-3 mb-3">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:linear-gradient(135deg,#e8b4b8,#c9888e)">
                <svg width="28" height="28" viewBox="0 0 120 120" fill="none">
                    <ellipse cx="60" cy="45" rx="14" ry="28" fill="rgba(255,255,255,0.8)"/>
                    <ellipse cx="60" cy="45" rx="14" ry="28" fill="rgba(255,255,255,0.6)" transform="rotate(90 60 60)"/>
                    <ellipse cx="60" cy="45" rx="14" ry="28" fill="rgba(255,255,255,0.5)" transform="rotate(45 60 60)"/>
                    <ellipse cx="60" cy="45" rx="14" ry="28" fill="rgba(255,255,255,0.5)" transform="rotate(135 60 60)"/>
                    <circle cx="60" cy="60" r="14" fill="white"/>
                </svg>
            </div>
        </div>
        <div class="text-white font-black text-2xl tracking-widest">NAY SPA</div>
        <div class="text-sm mt-1" style="color:rgba(255,255,255,0.5)">لوحة التحكم</div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl p-8 shadow-2xl">
        <h2 class="text-xl font-black mb-1" style="color:#1a1a1a">تسجيل الدخول</h2>
        <p class="text-sm mb-7" style="color:#888">أدخل بياناتك للوصول إلى لوحة التحكم</p>

        @if($errors->any())
        <div class="mb-5 p-4 rounded-xl text-sm" style="background:#fee2e2; color:#dc2626; border:1px solid #fecaca">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="form-label">البريد الإلكتروني</label>
                <div class="relative">
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-input"
                           placeholder="admin@nayspa.iq"
                           dir="ltr"
                           required autofocus>
                    <div class="absolute top-1/2 right-4 -translate-y-1/2" style="color:#c9888e">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label">كلمة المرور</label>
                <div class="relative">
                    <input type="password" name="password"
                           class="form-input"
                           placeholder="••••••••"
                           required>
                    <div class="absolute top-1/2 right-4 -translate-y-1/2" style="color:#c9888e">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded" style="accent-color:#c9888e">
                    <span class="text-sm" style="color:#555">تذكرني</span>
                </label>
            </div>

            <button type="submit" class="btn-primary w-full justify-center text-base py-4">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                دخول
            </button>
        </form>
    </div>

    <div class="text-center mt-6">
        <a href="{{ route('home') }}" class="text-sm transition-all hover:opacity-80" style="color:rgba(255,255,255,0.4)">
            ← العودة للموقع
        </a>
    </div>
</div>

</body>
</html>
