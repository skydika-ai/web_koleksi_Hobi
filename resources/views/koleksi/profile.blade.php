@extends('koleksi.layout')

@section('header_title')
    <h2 class="text-3xl font-[900] text-slate-800 tracking-tighter">Profil Akun ✨</h2>
    <p class="text-xs font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Kelola informasi data pribadimu</p>
@endsection

@section('content')
<div class="max-w-6xl space-y-8">
    
    <div class="bg-white p-8 rounded-[35px] border border-white shadow-sm flex flex-col md:flex-row items-center gap-12">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 bg-gradient-to-tr from-[#FF8FAB] to-[#FFC2D1] rounded-full flex items-center justify-center text-white font-[900] text-3xl shadow-inner shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="space-y-0.5">
                <h3 class="text-2xl font-[900] text-slate-800 tracking-tighter">{{ Auth::user()->name }}</h3>
                <span class="inline-block px-3 py-0.5 bg-[#FDECEC] text-[#FF8FAB] text-[9px] font-black uppercase tracking-wider rounded-full">Member HobiKita</span>
            </div>
        </div>

        <div class="flex items-center gap-10 text-center border-l border-slate-100 pl-10">
            <div>
                <h4 class="text-xl font-[900] text-slate-800 tracking-tight">{{ $totalKoleksi }}</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Koleksi</p>
            </div>
            <div>
                <h4 class="text-xl font-[900] text-slate-800 tracking-tight">3</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Kategori</p>
            </div>
            <div>
                <h4 class="text-xl font-[900] text-[#FF8FAB] tracking-tight">Aktif</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Status</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-8 rounded-[30px] border border-white shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center text-2xl">🎮</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalGame }}</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Koleksi Game</p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[30px] border border-white shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-2xl">🎬</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalFilm }}</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Koleksi Film</p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[30px] border border-white shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl">📚</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalBuku }}</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Koleksi Buku</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-5 bg-white p-8 rounded-[35px] border border-white shadow-sm space-y-5">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-50">
                <span class="text-sm">📝</span>
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Informasi Diri</h4>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider block mb-1.5">Nama Lengkap</label>
                    <div class="w-full bg-[#FBF7F4] px-5 py-3.5 rounded-2xl text-xs font-bold text-slate-700">{{ Auth::user()->name }}</div>
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider block mb-1.5">Email</label>
                    <div class="w-full bg-[#FBF7F4] px-5 py-3.5 rounded-2xl text-xs font-bold text-slate-700">{{ Auth::user()->email }}</div>
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider block mb-1.5">Terdaftar Sejak</label>
                    <div class="w-full bg-[#FBF7F4] px-5 py-3.5 rounded-2xl text-xs font-bold text-slate-700">{{ Auth::user()->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 bg-white p-8 rounded-[35px] border border-white shadow-sm space-y-5">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-50">
                <span class="text-sm">🕒</span>
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Aktivitas Terbaru</h4>
            </div>
            <div class="space-y-3.5 max-h-[310px] overflow-y-auto pr-1">
                @forelse(\App\Models\Koleksi::where('user_id', Auth::id())->latest()->take(4)->get() as $item)
                    <div class="flex items-center justify-between p-4 bg-[#FBF7F4] rounded-2xl">
                        <div class="flex items-center gap-3">
                            <span class="text-lg">
                                @if($item->kategori == 'game') 🎮
                                @elseif($item->kategori == 'film') 🎬
                                @else 📚 @endif
                            </span>
                            <p class="text-xs font-bold text-slate-600">
                                Menambahkan <span class="font-black text-slate-800">{{ $item->nama }}</span>
                            </p>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-12 text-slate-300 text-xs font-bold">Belum ada aktivitas.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection