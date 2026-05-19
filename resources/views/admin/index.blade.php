@extends('koleksi.layout')

@section('header_title')
    <h2 class="text-3xl font-[900] text-slate-800 tracking-tighter">Admin Panel 🛡️</h2>
    <p class="text-xs font-bold text-slate-400 uppercase tracking-[1px] mt-0.5">Kelola semua pengguna dan koleksi</p>
@endsection

@section('content')
<div class="space-y-8">

    {{-- ===== KARTU STATISTIK GLOBAL ===== --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-5">
        <div class="bg-white p-6 rounded-[28px] shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 bg-pink-50 rounded-2xl flex items-center justify-center text-xl shrink-0">👥</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalUsers }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">User</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[28px] shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center text-xl shrink-0">🗂️</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalKoleksi }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Total Koleksi</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[28px] shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 bg-pink-50 rounded-2xl flex items-center justify-center text-xl shrink-0">🎮</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalGame }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Game</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[28px] shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 bg-purple-50 rounded-2xl flex items-center justify-center text-xl shrink-0">🎬</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalFilm }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Film</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[28px] shadow-sm flex items-center gap-4">
            <div class="w-11 h-11 bg-blue-50 rounded-2xl flex items-center justify-center text-xl shrink-0">📚</div>
            <div>
                <h4 class="text-2xl font-[900] text-slate-800">{{ $totalBuku }}</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Buku</p>
            </div>
        </div>
    </div>

    {{-- ===== TABEL SEMUA USER ===== --}}
    <div class="bg-white rounded-[35px] shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-3">
            <div class="w-8 h-8 bg-pink-50 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-4 h-4 text-pink-400"></i>
            </div>
            <h3 class="text-sm font-[900] text-slate-800 tracking-tight">Daftar Semua Pengguna</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-50">
                        <th class="text-left px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Pengguna</th>
                        <th class="text-left px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="text-left px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Koleksi</th>
                        <th class="text-left px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Bergabung</th>
                        <th class="text-right px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="border-b border-slate-50 hover:bg-[#FBF7F4] transition-colors">
                        {{-- Nama & Email --}}
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gradient-to-tr from-[#FF8FAB] to-[#FFC2D1] rounded-full flex items-center justify-center text-white font-black text-xs shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-xs tracking-tight">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="text-pink-400">(Kamu)</span>
                                        @endif
                                    </p>
                                    <p class="text-[11px] font-bold text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Badge Role --}}
                        <td class="px-4 py-5">
                            @if($user->isAdmin())
                                <span class="px-3 py-1 bg-purple-50 text-purple-500 text-[10px] font-black rounded-full uppercase tracking-wider">
                                    🛡 Admin
                                </span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black rounded-full uppercase tracking-wider">
                                    👤 User
                                </span>
                            @endif
                        </td>

                        {{-- Jumlah koleksi (dari withCount) --}}
                        <td class="px-4 py-5">
                            <span class="text-xs font-black text-slate-600">{{ $user->koleksis_count }} item</span>
                        </td>

                        {{-- Tanggal daftar --}}
                        <td class="px-4 py-5">
                            <span class="text-xs font-bold text-slate-400">{{ $user->created_at->format('d M Y') }}</span>
                        </td>

                        {{-- Aksi: hapus user --}}
                        <td class="px-8 py-5 text-right">
                            @if($user->id !== auth()->id())
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      onsubmit="return confirm('Hapus akun {{ $user->name }}? Semua koleksinya ikut terhapus!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-400 text-[10px] font-black rounded-xl uppercase tracking-wider transition-all flex items-center gap-1 ml-auto">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] font-bold text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Sub-baris: koleksi milik user ini --}}
                    @if($user->koleksis_count > 0)
                    <tr class="bg-[#FBF7F4]">
                        <td colspan="5" class="px-12 py-3">
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->koleksis as $koleksi)
                                <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-2xl border border-slate-100 text-xs">
                                    <span>
                                        @if($koleksi->kategori == 'game') 🎮
                                        @elseif($koleksi->kategori == 'film') 🎬
                                        @else 📚 @endif
                                    </span>
                                    <span class="font-bold text-slate-700">{{ $koleksi->nama }}</span>

                                    {{-- Tombol hapus koleksi individual --}}
                                    <form method="POST"
                                          action="{{ route('admin.koleksi.destroy', $koleksi) }}"
                                          onsubmit="return confirm('Hapus koleksi {{ $koleksi->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-300 hover:text-red-500 transition-colors ml-1">
                                            <i data-lucide="x" class="w-3 h-3"></i>
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection