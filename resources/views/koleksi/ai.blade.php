@extends('koleksi.layout')

@section('header_title')
    <h2 class="text-3xl font-[900] text-slate-800 tracking-tighter">Analisis Hobi AI ✨</h2>
    <p class="text-xs font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Rekomendasi personal berdasarkan koleksimu</p>
@endsection

@section('content')
<div class="space-y-6">

    {{-- ===== LAYOUT 2 KOLOM: KIRI = STATISTIK, KANAN = ANALISIS AI ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ============================================================ --}}
        {{-- KOLOM KIRI — Raw Statistics                                   --}}
        {{-- ============================================================ --}}
        <div class="lg:col-span-4 space-y-4">

            {{-- Header panel kiri --}}
            <div class="bg-white rounded-[28px] shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-slate-400"></i>
                    <h3 class="text-xs font-black text-slate-500 uppercase tracking-wider">Raw Statistics</h3>
                </div>

                {{-- Tabel kategori --}}
                <div class="px-6 py-2">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="border-b border-slate-50">
                                <th class="text-left py-3 font-black text-[10px] text-slate-400 uppercase tracking-wider">Kategori</th>
                                <th class="text-center py-3 font-black text-[10px] text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="text-right py-3 font-black text-[10px] text-slate-400 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($koleksis)
                                @php
                                    $grouped = $koleksis->groupBy('kategori');
                                    $emojiMap = ['game' => '🎮', 'film' => '🎬', 'buku' => '📚'];
                                @endphp

                                @forelse($grouped as $kategori => $items)
                                <tr class="border-b border-slate-50">
                                    <td class="py-3 font-bold text-slate-700">
                                        {{ $emojiMap[$kategori] ?? '📁' }} {{ ucfirst($kategori) }}
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="px-2 py-0.5 bg-green-50 text-green-500 text-[9px] font-black rounded-full uppercase">
                                            Active
                                        </span>
                                    </td>
                                    <td class="py-3 text-right font-black text-slate-800">
                                        {{ $items->count() }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-6 text-center text-slate-300 text-xs font-bold">
                                        Belum ada koleksi
                                    </td>
                                </tr>
                                @endforelse
                            @endisset
                        </tbody>
                    </table>
                </div>

                {{-- Ringkasan total --}}
                @isset($koleksis)
                <div class="px-6 py-4 bg-[#FBF7F4] border-t border-slate-50 flex justify-between items-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total Semua</span>
                    <span class="text-lg font-[900] text-slate-800">{{ $koleksis->count() }}</span>
                </div>
                @endisset
            </div>

            {{-- Kartu per kategori --}}
            @isset($totalGame)
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white p-4 rounded-[22px] shadow-sm text-center">
                    <div class="text-2xl mb-1">🎮</div>
                    <h4 class="text-xl font-[900] text-slate-800">{{ $totalGame }}</h4>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Game</p>
                </div>
                <div class="bg-white p-4 rounded-[22px] shadow-sm text-center">
                    <div class="text-2xl mb-1">🎬</div>
                    <h4 class="text-xl font-[900] text-slate-800">{{ $totalFilm }}</h4>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Film</p>
                </div>
                <div class="bg-white p-4 rounded-[22px] shadow-sm text-center">
                    <div class="text-2xl mb-1">📚</div>
                    <h4 class="text-xl font-[900] text-slate-800">{{ $totalBuku }}</h4>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Buku</p>
                </div>
            </div>
            @endisset

            {{-- Tombol generate / generate ulang --}}
            <a href="{{ route('koleksi.ai') }}"
               class="w-full flex items-center justify-center gap-2 px-5 py-3.5 bg-gradient-to-r from-[#FF8FAB] to-[#FFC2D1] hover:from-[#ff7b9e] hover:to-[#ffb3c6] text-white rounded-2xl text-xs font-black uppercase tracking-wider transition-all shadow-sm shadow-pink-100">
                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                {{ isset($analisis) && $analisis ? 'Generate Ulang' : 'Analisis Sekarang' }}
            </a>

        </div>

        {{-- ============================================================ --}}
        {{-- KOLOM KANAN — Hasil Analisis AI                               --}}
        {{-- ============================================================ --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[28px] shadow-sm overflow-hidden h-full">

                {{-- Header panel kanan --}}
                <div class="px-7 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-tr from-[#FF8FAB] to-[#FFC2D1] rounded-xl flex items-center justify-center text-white shadow-sm shrink-0">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-[900] text-slate-800 tracking-tight">AI Academic Insight</h3>
                        <p class="text-[10px] font-bold text-slate-400">Analisis & rekomendasi personal berdasarkan koleksimu</p>
                    </div>
                </div>

                <div class="p-7">

                    @if(isset($analisis) && $analisis)
                        {{-- ✅ Hasil analisis AI berhasil --}}
                        <div class="prose prose-sm max-w-none">
                            <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $analisis }}
                            </div>
                        </div>

                        {{-- Footer info --}}
                        <div class="mt-6 pt-5 border-t border-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400">
                                <i data-lucide="cpu" class="w-3 h-3"></i>
                                Dibuat oleh Mistral AI via OpenRouter
                            </div>
                            <span class="text-[10px] font-bold text-slate-300">
                                {{ now()->format('d M Y, H:i') }}
                            </span>
                        </div>

                    @elseif(isset($pesan) && str_contains($pesan, 'Tambahkan'))
                        {{-- ⚠️ Koleksi masih kosong --}}
                        <div class="flex flex-col items-center justify-center py-16 text-center space-y-4">
                            <div class="w-16 h-16 bg-amber-50 rounded-full flex items-center justify-center text-3xl">📦</div>
                            <div>
                                <p class="text-sm font-black text-slate-600">Koleksi masih kosong!</p>
                                <p class="text-xs font-bold text-slate-400 mt-1">Tambahkan dulu koleksimu agar AI bisa menganalisis hobimu.</p>
                            </div>
                            <a href="{{ route('koleksi.create') }}"
                               class="mt-2 px-6 py-2.5 bg-[#FF8FAB] hover:bg-[#ff7b9e] text-white text-xs font-black rounded-2xl transition-all">
                                + Tambah Koleksi Sekarang
                            </a>
                        </div>

                    @elseif(isset($pesan))
                        {{-- ❌ API gagal / error --}}
                        <div class="flex flex-col items-center justify-center py-16 text-center space-y-4">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-3xl">⚠️</div>
                            <div>
                                <p class="text-sm font-black text-slate-600">Gagal menghubungi AI</p>
                                <p class="text-xs font-bold text-slate-400 mt-1">{{ $pesan }}</p>
                            </div>
                            <a href="{{ route('koleksi.ai') }}"
                               class="mt-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-500 text-xs font-black rounded-2xl transition-all">
                                Coba Lagi
                            </a>
                        </div>

                    @else
                        {{-- 🔄 Loading / belum di-generate --}}
                        <div class="flex flex-col items-center justify-center py-16 text-center space-y-4">
                            <div class="w-16 h-16 bg-purple-50 rounded-full flex items-center justify-center">
                                <i data-lucide="sparkles" class="w-7 h-7 text-purple-300"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-600">Siap menganalisis hobimu!</p>
                                <p class="text-xs font-bold text-slate-400 mt-1">Klik tombol <span class="text-pink-400">Analisis Sekarang</span> di sebelah kiri.</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

</div>
@endsection