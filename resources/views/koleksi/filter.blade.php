@extends('koleksi.layout')

@section('header_title')
    <h2 class="text-3xl font-[900] text-slate-800 tracking-tighter">Filter Kategori 📂</h2>
    <p class="text-xs font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Urutkan hobi berdasarkan kategori pilihan</p>
@endsection

@section('content')
<div class="space-y-8">
    
    <div class="flex items-center gap-3">
        <a href="{{ route('koleksi.filter', 'game') }}" class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider {{ isset($kategori) && $kategori == 'game' ? 'bg-[#FF8FAB] text-white' : 'bg-white text-slate-400 border border-slate-100 shadow-sm' }}">Game</a>
        
        <a href="{{ route('koleksi.filter', 'buku') }}" class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider {{ isset($kategori) && $kategori == 'buku' ? 'bg-[#FF8FAB] text-white' : 'bg-white text-slate-400 border border-slate-100 shadow-sm' }}">Buku</a>
        
        <a href="{{ route('koleksi.filter', 'film') }}" class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider {{ isset($kategori) && $kategori == 'film' ? 'bg-[#FF8FAB] text-white' : 'bg-white text-slate-400 border border-slate-100 shadow-sm' }}">Film</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @forelse($koleksis as $item)
            <div class="bg-white p-4 rounded-[28px] border border-slate-50 shadow-sm space-y-4">
                
                <div class="w-full aspect-square rounded-[20px] bg-slate-100 overflow-hidden relative">
                    @if($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-pink-50 text-pink-300">
                            <i data-lucide="image" class="w-6 h-6"></i>
                        </div>
                    @endif
                </div>

                <div class="pb-1">
                    <div class="text-center mb-3">
                        <p class="text-[9px] font-black text-pink-400 uppercase tracking-widest mb-0.5">{{ $item->kategori }}</p>
                        <h5 class="font-bold text-slate-800 text-sm tracking-tight">{{ $item->nama }}</h5>
                    </div>

                    <div class="flex items-center gap-1.5 pt-2 border-t border-slate-50">
                        <a href="{{ route('koleksi.show', $item->id) }}" class="flex-1 bg-slate-50 hover:bg-slate-100 text-slate-600 py-1.5 rounded-lg text-center text-[10px] font-bold transition-all">
                            Detail
                        </a>
                        
                        <a href="{{ route('koleksi.edit', $item->id) }}" class="p-1.5 bg-pink-50 text-[#FF8FAB] rounded-lg hover:bg-[#FF8FAB] hover:text-white transition-all">
                            <i data-lucide="edit-2" class="w-3 h-3"></i>
                        </a>
                        
                        <form action="{{ route('koleksi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus koleksi ini?');" class="inline">
                            @csrf
                            @method('DELETE') <button type="submit" class="p-1.5 bg-red-50 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all">
                                <i data-lucide="trash-2" class="w-3 h-3"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
    @empty
            <div class="col-span-4 text-center py-16 text-slate-400 text-xs font-bold bg-white rounded-[30px] border border-white shadow-sm">
                Belum ada item untuk kategori ini.
            </div>
        @endforelse
    </div>
</div>
@endsection