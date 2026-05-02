<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TanteFaniPay - Aplikasi Pencatatan Kiriman">
    <title>@yield('title', 'Dashboard') — TanteFaniPay</title>
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
        .glass-card{background:rgba(30,41,59,.5);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.06);transition:all .3s cubic-bezier(.4,0,.2,1)}
        .glass-card:hover{background:rgba(30,41,59,.7);border-color:rgba(139,92,246,.3);transform:translateY(-2px);box-shadow:0 8px 32px rgba(139,92,246,.1)}
        .sidebar-link{transition:all .2s ease;position:relative;overflow:hidden}
        .sidebar-link::before{content:'';position:absolute;left:0;top:0;height:100%;width:3px;background:linear-gradient(180deg,#8b5cf6,#a78bfa);border-radius:0 4px 4px 0;transform:scaleY(0);transition:transform .2s ease}
        .sidebar-link:hover::before,.sidebar-link.active::before{transform:scaleY(1)}
        .sidebar-link.active{background:rgba(139,92,246,.1);color:#a78bfa}
        .btn-primary{background:linear-gradient(135deg,#8b5cf6,#7c3aed);transition:all .3s ease}
        .btn-primary:hover{background:linear-gradient(135deg,#a78bfa,#8b5cf6);transform:translateY(-1px);box-shadow:0 4px 16px rgba(139,92,246,.3)}
        .btn-danger{background:linear-gradient(135deg,#ef4444,#dc2626);transition:all .3s ease}
        .btn-danger:hover{background:linear-gradient(135deg,#f87171,#ef4444);transform:translateY(-1px);box-shadow:0 4px 16px rgba(239,68,68,.3)}
        .stat-card{position:relative;overflow:hidden}
        .stat-card::after{content:'';position:absolute;top:-50%;right:-50%;width:100%;height:100%;background:radial-gradient(circle,rgba(139,92,246,.08) 0%,transparent 70%);pointer-events:none}
        .fade-in{animation:fadeIn .5s ease-out}
        @keyframes fadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
        ::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:rgba(15,23,42,.5)}::-webkit-scrollbar-thumb{background:rgba(100,116,139,.5);border-radius:3px}
        .table-row{transition:all .15s ease}.table-row:hover{background:rgba(139,92,246,.05)}
        input:focus,select:focus,textarea:focus{outline:none;box-shadow:0 0 0 2px rgba(139,92,246,.3)}
        .toast{animation:toastIn .4s ease-out,toastOut .4s ease-in 3.6s forwards}
        @keyframes toastIn{from{opacity:0;transform:translateY(-20px) scale(.95)}to{opacity:1;transform:translateY(0) scale(1)}}
        @keyframes toastOut{from{opacity:1;transform:translateY(0) scale(1)}to{opacity:0;transform:translateY(-20px) scale(.95)}}
    </style>
</head>
<body class="text-gray-200 antialiased">
@if(session('success'))
<div id="toast" class="toast fixed top-6 right-6 z-[60] max-w-sm">
    <div class="glass rounded-xl px-5 py-4 flex items-center gap-3 border-l-4 border-brand-500 shadow-2xl">
        <svg class="w-5 h-5 text-brand-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <p class="text-sm font-medium text-gray-100">{{ session('success') }}</p>
    </div>
</div>
@endif
<div class="flex min-h-screen">
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>
<aside id="sidebar" class="glass fixed lg:sticky top-0 left-0 h-screen w-64 z-50 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <div class="p-6 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
            </div>
            <div>
                <h1 class="text-base font-bold text-white tracking-tight">TanteFaniPay</h1>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest">Pencatatan Kiriman</p>
            </div>
        </div>
    </div>
    <nav class="flex-1 p-4 space-y-1">
        <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="{{ route('transaksi.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Daftar Transaksi
        </a>
        <a href="{{ route('transaksi.create') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Transaksi
        </a>
    </nav>
    <div class="p-4 border-t border-white/5">
        <div class="glass-card rounded-lg p-3">
            <p class="text-xs text-gray-400">Versi 1.0</p>
            <p class="text-[10px] text-gray-500 mt-1">&copy; {{ date('Y') }} TanteFaniPay</p>
        </div>
    </div>
</aside>
<div class="flex-1 flex flex-col min-w-0">
    <header class="glass sticky top-0 z-30 px-4 lg:px-8 py-4 flex items-center justify-between border-b border-white/5">
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-white/5 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div>
            <h2 class="text-lg font-semibold text-white">@yield('header', 'Dashboard')</h2>
            <p class="text-xs text-gray-400 mt-0.5">@yield('subheader', 'Selamat datang di TanteFaniPay')</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs text-gray-400 hidden sm:block">{{ now()->translatedFormat('l, d F Y') }}</span>
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-brand-500/20">TF</div>
        </div>
    </header>
    <main class="flex-1 p-4 lg:p-8 fade-in">@yield('content')</main>
</div>
</div>
<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebarOverlay').classList.toggle('hidden');
}
setTimeout(()=>{const t=document.getElementById('toast');if(t)t.remove()},4000);
</script>
@yield('scripts')
</body>
</html>
