@extends('koleksi.layout')

@section('content')
<div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    
    <div class="bg-white w-full max-w-lg rounded-[35px] border border-slate-50 shadow-2xl p-8 relative animate-in fade-in zoom-in-95 duration-200 my-auto">
        
        <a href="{{ route('koleksi.index') }}" class="absolute top-6 right-6 p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-full transition-all">
            <i data-lucide="x" class="w-5 h-5"></i>
        </a>

        <div class="text-center mb-6">
            <h3 class="text-2xl font-[900] text-slate-800 tracking-tighter flex items-center justify-center gap-1">Edit Koleksi ✨</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Perbarui rincian informasi memori hobimu</p>
        </div>

        <form action="{{ route('koleksi.update', $koleksi->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Nama Hobi</label>
                <input type="text" name="nama" value="{{ old('nama', $koleksi->nama) }}" required
                    class="w-full bg-[#FFF8F9] border border-transparent focus:border-pink-100 focus:bg-white px-4 py-3 rounded-xl text-xs font-bold text-slate-700 outline-none transition-all">
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Kategori</label>
                <select name="kategori" required
                    class="w-full bg-[#FFF8F9] border border-transparent focus:border-pink-100 focus:bg-white px-4 py-3 rounded-xl text-xs font-bold text-slate-600 outline-none transition-all cursor-pointer">
                    <option value="game" {{ $koleksi->kategori == 'game' ? 'selected' : '' }}>🎮 Game</option>
                    <option value="buku" {{ $koleksi->kategori == 'buku' ? 'selected' : '' }}>📚 Buku</option>
                    <option value="film" {{ $koleksi->kategori == 'film' ? 'selected' : '' }}>🎬 Film</option>
                </select>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Rating Hobi</label>
                <input type="hidden" name="rating" id="rating-value-edit" value="{{ $koleksi->rating }}" required>
                
                <div class="flex items-center gap-1.5 bg-[#FFF8F9] p-3 rounded-xl w-fit">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRatingEdit({{ $i }})" class="text-xl outline-none focus:outline-none">
                            <span id="star-edit-{{ $i }}" class="{{ $i <= $koleksi->rating ? 'text-amber-400 font-bold' : 'text-slate-300' }}">★</span>
                        </button>
                    @endfor
                    <span id="rating-text-edit" class="text-[10px] font-black text-[#FF8FAB] uppercase tracking-wider ml-2">
                        @if($koleksi->rating == 1) (Buruk) @elseif($koleksi->rating == 2) (Lumayan) @elseif($koleksi->rating == 3) (Bagus) @elseif($koleksi->rating == 4) (Sangat Bagus) @else (Sempurna) @endif
                    </span>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Catatan / Deskripsi</label>
                <textarea name="catatan" rows="2" class="w-full bg-[#FFF8F9] border border-transparent focus:border-pink-100 focus:bg-white px-4 py-3 rounded-xl text-xs font-bold text-slate-700 outline-none transition-all resize-none">{{ old('catatan', $koleksi->catatan) }}</textarea>
            </div>

            <div class="space-y-1">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-wider block">Ganti Foto (Opsional)</label>
                <div class="flex items-center gap-3 p-2.5 bg-slate-50/50 rounded-xl border border-dashed border-slate-100">
                    <div class="w-11 h-11 bg-slate-100 rounded-lg overflow-hidden shrink-0 relative">
                        @if($koleksi->gambar)
                            <img src="{{ asset('storage/' . $koleksi->gambar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300"><i data-lucide="image" class="w-4 h-4"></i></div>
                        @endif
                    </div>
                    <input type="file" name="gambar" accept="image/*" class="text-[9px] font-bold text-slate-400 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[9px] file:font-black file:bg-pink-50 file:text-[#FF8FAB] cursor-pointer">
                </div>
            </div>

            <div class="pt-1">
                <button type="submit" class="w-full bg-[#FF8FAB] hover:bg-[#ff7b9e] text-white py-3 rounded-xl text-xs font-black uppercase tracking-wider shadow-md shadow-pink-50 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const labelRatingEdit = {1: '(Buruk)', 2: '(Lumayan)', 3: '(Bagus)', 4: '(Sangat Bagus)', 5: '(Sempurna)'};

function setRatingEdit(val) {
    document.getElementById('rating-value-edit').value = val;
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById(`star-edit-${i}`);
        if (i <= val) {
            star.className = "text-amber-400 font-bold";
        } else {
            star.className = "text-slate-300";
        }
    }
    document.getElementById('rating-text-edit').innerText = labelRatingEdit[val];
}
</script>
@endsection