@extends('koleksi.layout')

@section('header_title')
    <h2 class="text-3xl font-[900] text-slate-800 tracking-tighter">Tambah Hobi Baru ✨</h2>
    <p class="text-xs font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Simpan memori koleksimu di sini</p>
@endsection

@section('content')
<div class="max-w-4xl bg-white p-8 rounded-[35px] border border-white shadow-sm">
    <form action="{{ route('koleksi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label class="text-xs font-black text-slate-500 uppercase tracking-wider block">Nama Koleksi</label>
            <input type="text" name="nama" placeholder="Misal: Atomic Habits / Valorant" required
                class="w-full bg-[#FFF8F9] border border-transparent focus:border-pink-200 focus:bg-white px-5 py-4 rounded-2xl text-sm font-bold text-slate-700 outline-none transition-all placeholder:text-slate-300">
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black text-slate-500 uppercase tracking-wider block">Pilih Kategori</label>
            <input type="hidden" name="kategori" id="selected-kategori" required>
            <div class="grid grid-cols-3 gap-4">
                <button type="button" onclick="selectKategori('game', this)" id="btn-game" class="kat-btn flex items-center justify-center gap-2 py-4 rounded-2xl border text-sm font-bold tracking-tight transition-all duration-300 bg-white border-slate-100 text-slate-500 shadow-sm hover:bg-slate-50">
                    <span>🎮</span> Game
                </button>
                <button type="button" onclick="selectKategori('buku', this)" id="btn-buku" class="kat-btn flex items-center justify-center gap-2 py-4 rounded-2xl border text-sm font-bold tracking-tight transition-all duration-300 bg-white border-slate-100 text-slate-500 shadow-sm hover:bg-slate-50">
                    <span>📚</span> Buku
                </button>
                <button type="button" onclick="selectKategori('film', this)" id="btn-film" class="kat-btn flex items-center justify-center gap-2 py-4 rounded-2xl border text-sm font-bold tracking-tight transition-all duration-300 bg-white border-slate-100 text-slate-500 shadow-sm hover:bg-slate-50">
                    <span>🎬</span> Film
                </button>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black text-slate-500 uppercase tracking-wider block">Berikan Rating</label>
            
            <input type="hidden" name="rating" id="rating-value" value="0" required>
            
            <div class="flex items-center gap-2 bg-[#FFF8F9] p-4 rounded-2xl w-fit border border-transparent">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" onmouseover="hoverRating({{ $i }})" onmouseleave="resetRating()" class="text-2xl transition-all duration-150 transform hover:scale-125 outline-none focus:outline-none">
                        <span id="star-{{ $i }}" class="text-slate-300">★</span>
                    </button>
                @endfor
                <span id="rating-text" class="text-xs font-black text-slate-400 uppercase tracking-wider ml-3">Pilih Bintang</span>
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black text-slate-500 uppercase tracking-wider block">Catatan Hobi</label>
            <textarea name="catatan" rows="4" placeholder="Tuliskan cerita singkat tentang hobimu ini..."
                class="w-full bg-[#FFF8F9] border border-transparent focus:border-pink-200 focus:bg-white px-5 py-4 rounded-2xl text-sm font-bold text-slate-700 outline-none transition-all resize-none"></textarea>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black text-slate-500 uppercase tracking-wider block">Foto Sampul (Opsional)</label>
            <input type="file" name="gambar" accept="image/*"
                class="w-full bg-[#FFF8F9] border border-transparent px-5 py-3.5 rounded-2xl text-xs font-bold text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-pink-50 file:text-[#FF8FAB] hover:file:bg-pink-100 file:transition-all">
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('koleksi.index') }}" class="px-6 py-3.5 bg-slate-50 hover:bg-slate-100 text-slate-500 font-bold rounded-2xl text-xs uppercase tracking-wider transition-all">Batal</a>
            <button type="submit" class="px-8 py-3.5 bg-[#FF8FAB] hover:bg-[#ff7b9e] text-white font-black rounded-2xl text-xs uppercase tracking-wider shadow-sm shadow-pink-100 transition-all">Simpan Koleksi ✨</button>
        </div>
    </form>
</div>

<script>
// Penanganan Seleksi Kategori Berwarna
function selectKategori(value, element) {
    document.getElementById('selected-kategori').value = value;
    document.querySelectorAll('.kat-btn').forEach(btn => {
        btn.classList.remove('bg-[#FF8FAB]', 'text-white', 'border-transparent');
        btn.classList.add('bg-white', 'text-slate-500', 'border-slate-100');
    });
    element.classList.remove('bg-white', 'text-slate-500', 'border-slate-100');
    element.classList.add('bg-[#FF8FAB]', 'text-white', 'border-transparent');
}

// Variabel penampung state rating
let currentRating = 0;
const labelRating = {1: '(Buruk)', 2: '(Lumayan)', 3: '(Bagus)', 4: '(Sangat Bagus)', 5: '(Sempurna)'};

// Fungsi saat bintang diklik permanen
function setRating(val) {
    currentRating = val;
    document.getElementById('rating-value').value = val;
    updateStars(val);
}

// Fungsi efek hover saat kursor melintas di atas bintang
function hoverRating(val) {
    updateStars(val);
}

// Fungsi mengembalikan visual saat kursor pergi meninggalkan bintang
function resetRating() {
    updateStars(currentRating);
}

// Inti mesin pengubah warna class bintang visual Tailwind
function updateStars(val) {
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById(`star-${i}`);
        if (i <= val) {
            // Jika masuk hitungan rating, ubah jadi kuning emas/pink terang berkilau
            star.className = "text-amber-400 font-bold";
        } else {
            // Jika diluar nilai rating, matikan warnanya jadi abu-abu redup kembali
            star.className = "text-slate-300";
        }
    }
    
    // Perbarui label teks pendukung hobi di sebelah kanan bintang
    const textSpan = document.getElementById('rating-text');
    if (val > 0) {
        textSpan.innerText = labelRating[val];
        textSpan.className = "text-xs font-black text-[#FF8FAB] uppercase tracking-wider ml-3";
    } else {
        textSpan.innerText = "Pilih Bintang";
        textSpan.className = "text-xs font-black text-slate-400 uppercase tracking-wider ml-3";
    }
}
</script>
@endsection