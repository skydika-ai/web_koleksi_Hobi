<div class="bg-white p-4 rounded-[45px] shadow-sm border border-white group hover:shadow-2xl hover:shadow-pink-100/40 transition-all duration-700 relative overflow-hidden">
    <a href="{{ route('koleksi.show', $item->id) }}">
        <div class="h-56 bg-[#FBF7F4] rounded-[35px] mb-6 overflow-hidden">
            @if($item->gambar)
                <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-all duration-1000">
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-200">
                    <i data-lucide="image" class="w-10 h-10"></i>
                </div>
            @endif
        </div>
        <div class="px-3 pb-2 text-center">
            <p class="text-[10px] font-black text-[#FF8FAB] uppercase tracking-[3px] mb-2">{{ $item->kategori }}</p>
            <h4 class="font-extrabold text-slate-800 text-lg leading-tight capitalize">{{ $item->nama }}</h4>
        </div>
    </a>
    
    <div class="absolute top-6 right-6 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
        <a href="{{ route('koleksi.edit', $item->id) }}" class="w-8 h-8 bg-white/95 rounded-xl shadow-sm flex items-center justify-center text-xs hover:text-[#FF8FAB] transition-all">✏️</a>
        <form action="{{ route('koleksi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus hobi ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="w-8 h-8 bg-white/95 rounded-xl shadow-sm flex items-center justify-center text-xs hover:text-red-500 transition-all">🗑️</button>
        </form>
    </div>
</div>