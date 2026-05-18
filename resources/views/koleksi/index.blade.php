@extends('koleksi.layout')

@section('header_title')
    <h2 class="text-3xl font-[900] text-slate-800 tracking-tighter">Selamat Datang, {{ Auth::user()->name }} ✨</h2>
    <p class="text-xs font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Ayo kelola hobi serumu hari ini!</p>
@endsection

@section('content')
<div class="space-y-10">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-7 rounded-[30px] border border-white shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Total Koleksi</p>
                <h3 class="text-3xl font-[900] text-slate-800">{{ \App\Models\Koleksi::where('user_id', Auth::id())->count() }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-400 rounded-2xl flex items-center justify-center"><i data-lucide="layers"></i></div>
        </div>

    <div class="bg-white p-7 rounded-[30px] border border-white shadow-sm flex items-center justify-between">
    <div>
        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Kategori Favorit</p>
        <h3 class="text-xl font-[900] text-slate-800">
            @php
                $kategoriFavorit = \App\Models\Koleksi::where('user_id', Auth::id())
                    ->selectRaw('kategori, COUNT(*) as total')
                    ->groupBy('kategori')
                    ->orderByDesc('total')
                    ->first();
            @endphp

            {{ $kategoriFavorit ? ucfirst($kategoriFavorit->kategori) : 'Belum Ada' }}
        </h3>
    </div>
    <div class="w-12 h-12 bg-pink-50 text-pink-400 rounded-2xl flex items-center justify-center"><i data-lucide="heart"></i></div>
</div>

        <div class="bg-white p-7 rounded-[30px] border border-white shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">Rekomendasi AI</p>
                <p class="text-xs font-bold text-slate-500">Cek koleksi hobi barumu!</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-400 rounded-2xl flex items-center justify-center"><i data-lucide="sparkles"></i></div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider">Koleksi Terbaru</h4>

                @if(request('search'))
                    <p class="text-[11px] font-bold text-slate-400 mt-1">
                        Hasil pencarian untuk:
                        <span class="text-[#FF8FAB] font-black">"{{ request('search') }}"</span>
                    </p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('koleksi.index') }}" method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari koleksi..."
                            class="w-64 bg-white border border-slate-100 focus:border-pink-200 px-4 py-3 pr-10 rounded-2xl text-xs font-bold text-slate-600 outline-none transition-all placeholder:text-slate-300 shadow-sm">
                        <i data-lucide="search" class="w-4 h-4 text-slate-300 absolute right-3 top-1/2 -translate-y-1/2"></i>
                    </div>

                    <button type="submit" class="px-5 py-3 bg-[#FF8FAB] hover:bg-[#ff7b9e] text-white rounded-2xl text-xs font-black uppercase tracking-wider transition-all">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('koleksi.index') }}" class="px-5 py-3 bg-slate-50 hover:bg-slate-100 text-slate-500 rounded-2xl text-xs font-black uppercase tracking-wider transition-all">
                            Reset
                        </a>
                    @endif
                </form>

                <a href="{{ route('koleksi.create') }}" class="px-5 py-3 bg-white hover:bg-pink-50 text-[#FF8FAB] rounded-2xl text-xs font-black uppercase tracking-wider flex items-center justify-center gap-1 border border-slate-100 shadow-sm transition-all">
                    + Tambah Baru
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($koleksis as $item)
                <div class="bg-white p-4 rounded-[30px] border border-slate-100 shadow-sm space-y-4 group relative">
                    <div class="w-full aspect-[4/3] rounded-[22px] bg-slate-100 overflow-hidden relative">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-pink-50 text-pink-300">
                                <i data-lucide="image" class="w-8 h-8"></i>
                            </div>
                        @endif
                    </div>

                    <div class="px-2 pb-2">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-[9px] font-black text-pink-400 uppercase tracking-widest mb-0.5">{{ $item->kategori }}</p>
                                <h5 class="font-bold text-slate-800 text-base tracking-tight">{{ $item->nama }}</h5>
                            </div>

                            <div class="flex text-amber-400 text-xs gap-0.5">
                                @for($i = 1; $i <= $item->rating; $i++)
                                    ⭐
                                @endfor
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-wider
                                {{ $item->status == 'dimiliki' ? 'bg-green-50 text-green-400' : 'bg-amber-50 text-amber-400' }}">
                                {{ $item->status }}
                            </span>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('koleksi.show', $item) }}" class="w-8 h-8 rounded-xl bg-slate-50 hover:bg-pink-50 flex items-center justify-center text-slate-400 hover:text-pink-400 transition-all">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                </a>

                                <a href="{{ route('koleksi.edit', $item) }}" class="w-8 h-8 rounded-xl bg-slate-50 hover:bg-blue-50 flex items-center justify-center text-slate-400 hover:text-blue-400 transition-all">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                </a>

                                <form method="POST" action="{{ route('koleksi.destroy', $item) }}" onsubmit="return confirm('Hapus koleksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-slate-50 hover:bg-red-50 flex items-center justify-center text-slate-400 hover:text-red-400 transition-all">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 text-slate-300">
                    <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3"></i>

                    @if(request('search'))
                        <p class="text-sm font-bold">Tidak ada koleksi yang cocok dengan pencarian.</p>
                        <a href="{{ route('koleksi.index') }}" class="mt-4 inline-block px-6 py-2.5 bg-slate-100 text-slate-500 text-xs font-black rounded-2xl">
                            Reset Pencarian
                        </a>
                    @else
                        <p class="text-sm font-bold">Belum ada koleksi. Yuk tambah!</p>
                        <a href="{{ route('koleksi.create') }}" class="mt-4 inline-block px-6 py-2.5 bg-[#FF8FAB] text-white text-xs font-black rounded-2xl">
                            + Tambah Sekarang
                        </a>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection