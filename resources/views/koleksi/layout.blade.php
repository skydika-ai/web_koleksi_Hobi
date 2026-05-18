<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HobiKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FBF7F4; color: #4A4A4A; }
        .sidebar { width: 280px; height: 100vh; position: fixed; background: white; padding: 40px 24px; z-index: 50; display: flex; flex-direction: column; }
        .main-content { margin-left: 280px; padding: 40px 60px; }
        .nav-link { display: flex; align-items: center; gap: 14px; padding: 14px 20px; border-radius: 16px; font-weight: 600; font-size: 14px; color: #94A3B8; transition: all 0.3s ease; }
        .nav-link.active { background: #FDECEC; color: #FF8FAB; }
        .nav-link:hover:not(.active) { color: #475569; background: #F8FAFC; }
    </style>
</head>
<body>

    <aside class="sidebar border-r border-slate-50 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        <div class="flex items-center gap-3 mb-14 px-3">
            <div class="w-10 h-10 bg-gradient-to-tr from-[#FF8FAB] to-[#FFC2D1] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-pink-100">
                <i data-lucide="sparkles" class="w-5 h-5"></i>
            </div>
            <h1 class="text-2xl font-[900] tracking-tighter text-slate-800">HobiKita</h1>
        </div>
        
        <nav class="space-y-1.5 flex-1">
            <p class="text-[10px] font-extrabold text-slate-300 uppercase tracking-[2px] px-5 mb-5">Menu Utama</p>
            <a href="{{ route('koleksi.index') }}" class="nav-link {{ request()->routeIs('koleksi.index') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('koleksi.create') }}" class="nav-link {{ request()->routeIs('koleksi.create') ? 'active' : '' }}">
                <i data-lucide="plus-circle"></i> Tambah Baru
            </a>
            <a href="{{ route('koleksi.filter', 'game') }}" class="nav-link {{ request()->is('*filter*') ? 'active' : '' }}">
                <i data-lucide="filter"></i> Filter Kategori
            </a>
        </nav>

        <div class="space-y-1">
            <a href="{{ route('koleksi.profile') }}" class="nav-link {{ request()->routeIs('koleksi.profile') ? 'active' : '' }}">
                <i data-lucide="user"></i> Profil Saya
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-full text-left text-pink-400 hover:bg-pink-50">
                    <i data-lucide="log-out"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="flex items-center justify-between mb-12 -mt-1">
            <div>
                @yield('header_title')
            </div>
            
            @if(!request()->routeIs('koleksi.profile'))
            <a href="{{ route('koleksi.profile') }}" class="flex items-center gap-3 p-1.5 pr-4 rounded-full bg-white border border-slate-100 shadow-sm hover:border-pink-200 transition-all duration-300 group">
                <div class="w-9 h-9 bg-gradient-to-tr from-[#FF8FAB] to-[#FFC2D1] rounded-full flex items-center justify-center text-white font-black text-xs shadow-sm group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="text-left hidden sm:block">
                    <p class="text-xs font-black text-slate-700 tracking-tight">{{ Auth::user()->name }} ✨</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Profil Saya</p>
                </div>
            </a>
            @endif
        </header>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-100 text-green-500 px-5 py-4 rounded-2xl text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>