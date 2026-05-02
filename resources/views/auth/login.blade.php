<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TanteFaniPay - Login">
    <title>Login — TanteFaniPay</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon_fanipay.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: { 50:'#f5f3ff',100:'#ede9fe',200:'#ddd6fe',300:'#c4b5fd',400:'#a78bfa',500:'#8b5cf6',600:'#7c3aed',700:'#6d28d9',800:'#5b21b6',900:'#4c1d95' },
                        dark: { 50:'#f5f7fa',100:'#ebeef3',200:'#d2d9e5',300:'#aab8cd',400:'#7c92b0',500:'#5b7597',600:'#475d7e',700:'#3a4c66',800:'#334156',900:'#1e293b',950:'#0f172a' }
                    }
                }
            }
        }
    </script>
    <style>
        *{font-family:'Inter',sans-serif}
        body{background:linear-gradient(135deg,#0f0a1e 0%,#1a1333 40%,#0f172a 100%);min-height:100vh}
        .glass{background:rgba(30,41,59,.6);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,.08)}
        .btn-primary{background:linear-gradient(135deg,#8b5cf6,#7c3aed);transition:all .3s ease}
        .btn-primary:hover{background:linear-gradient(135deg,#a78bfa,#8b5cf6);transform:translateY(-1px);box-shadow:0 4px 16px rgba(139,92,246,.3)}
        input:focus,select:focus{outline:none;box-shadow:0 0 0 2px rgba(139,92,246,.3)}
        .fade-in{animation:fadeIn .6s ease-out}
        @keyframes fadeIn{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        .float-anim{animation:float 3s ease-in-out infinite}
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 text-gray-200 antialiased">
    <div class="w-full max-w-md fade-in">
        {{-- Logo & Title --}}
        <div class="text-center mb-8">
            <div class="inline-block float-anim">
                <img src="{{ asset('images/icon_fanipay.png') }}" alt="TanteFaniPay" class="w-20 h-20 rounded-2xl shadow-2xl shadow-brand-500/20 mx-auto object-contain bg-brand-700 p-1">
            </div>
            <h1 class="text-2xl font-bold text-white mt-5 tracking-tight">TanteFaniPay</h1>
            <p class="text-sm text-gray-400 mt-1">Masuk ke akun Anda</p>
        </div>

        {{-- Login Card --}}
        <div class="glass rounded-2xl p-8">
            @if($errors->any())
                <div class="mb-5 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20">
                    @foreach($errors->all() as $error)
                        <p class="text-xs text-red-400 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                @csrf

                {{-- User Dropdown --}}
                <div>
                    <label for="user_id" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Pilih Pengguna</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <select id="user_id" name="user_id" required
                                class="w-full bg-dark-950/50 border border-white/10 rounded-xl pl-11 pr-4 py-3 text-sm text-gray-200 focus:border-brand-500/50 transition-colors appearance-none cursor-pointer">
                            <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>— Pilih nama —</option>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Password</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <input type="password" id="password" name="password" required placeholder="Masukkan password..."
                               class="w-full bg-dark-950/50 border border-white/10 rounded-xl pl-11 pr-12 py-3 text-sm text-gray-200 placeholder-gray-500 focus:border-brand-500/50 transition-colors">
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <label class="flex items-center gap-2.5 cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-dark-950/50 text-brand-500 focus:ring-brand-500/30 focus:ring-offset-0 cursor-pointer">
                    <span class="text-sm text-gray-400 group-hover:text-gray-300 transition-colors">Ingat saya</span>
                </label>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full rounded-xl py-3 text-sm font-semibold text-white flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-600 mt-6">&copy; {{ date('Y') }} TanteFaniPay · Pencatatan Kiriman</p>
    </div>

    <script>
    function togglePassword() {
        const inp = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>';
        } else {
            inp.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }
    </script>
</body>
</html>
