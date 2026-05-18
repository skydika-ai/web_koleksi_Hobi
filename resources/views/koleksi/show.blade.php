@extends('koleksi.layout')

@section('content')
<div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    
    <div class="bg-white w-full max-w-lg rounded-[35px] border border-slate-50 shadow-2xl p-8 relative animate-in fade-in zoom-in-95 duration-200 my-auto">
        
        <a href="{{ route('koleksi.index') }}" class="absolute top-6 right-6 p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-full transition-all">
            <i data-lucide="x" class="w-5 h-5"></i>
        </a>

        <div class="text-center mb-6">
            <span class="inline-block px-3 py-1 bg-pink-50 text-[#FF8FAB] text-[10px] font-black uppercase tracking-widest rounded-full mb-2">
                {{ $koleksi->kategori }}
            </span>
            <h3 class="text-2xl font-[900] text-slate-800 tracking-tighter">{{ $koleksi->nama }}</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Rincian Informasi Koleksi Hobi</p>
        </div>

        <div class="space-y-5">
            
            <div class="w-full aspect-video bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-inner relative">
                @if($koleksi->gambar)
                    <img src="{{ asset('storage/' . $koleksi->gambar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300 bg-pink-50/30">
                        <i data-lucide="image" class="w-8 h-8 text-pink-200"></i>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-[#FFF8F9] p-3.5 rounded-xl">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider block mb-0.5">Kategori</span>
                    <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                        @if($koleksi->kategori == 'game') <span>🎮</span> Game 
                        @elseif($koleksi->kategori == 'buku') <span>📚</span> Buku 
                        @else <span>🎬</span> Film @endif
                    </span>
                </div>
                
                <div class="bg-[#FFF8F9] p-3.5 rounded-xl">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider block mb-0.5">Rating Kamu</span>
                    <div class="flex items-center gap-0.5 text-xs text-amber-400 font-bold">
                        @for($i = 1; $i <= 5; $i++)
                            <span>{{ $i <= $koleksi->rating ? '★' : '☆' }}</span>
                        @endfor
                    </div>
                </div>
            </div>

            <div class="bg-[#FFF8F9] p-4 rounded-xl">
                <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider block mb-1">Catatan / Deskripsi</span>
                <p class="text-xs font-bold text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $koleksi->catatan ?? 'Tidak ada catatan tambahan untuk hobi ini.' }}
                </p>
            </div>

            <div class="pt-2 flex gap-3">
                <a href="{{ route('koleksi.index') }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-500 py-3 rounded-xl text-center text-xs font-black uppercase tracking-wider transition-all">
                    Kembali
                </a>
                <a href="{{ route('koleksi.edit', $koleksi->id) }}" class="flex-1 bg-[#FF8FAB] hover:bg-[#ff7b9e] text-white py-3 rounded-xl text-center text-xs font-black uppercase tracking-wider shadow-md shadow-pink-50 transition-all">
                    Edit Data ✏️
                </a>
            </div>

        </div>
    </div>
</div>
@endsection