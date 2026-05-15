@extends('koleksi.layout')

@section('title', 'Koleksiku')

@section('content')

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.2rem; padding-bottom:0.8rem; border-bottom:2px solid #e94560;">
        <h1 style="font-size:1.3rem; font-weight:700;">Koleksiku</h1>
        <div style="display:flex; gap:0.6rem;">
            <a href="{{ route('koleksi.ai') }}" class="btn btn-ai">Rekomendasi AI</a>
            <a href="{{ route('koleksi.create') }}" class="btn btn-primary">+ Tambah Koleksi</a>
        </div>
    </div>

    @if ($koleksis->isEmpty())
        {{-- Tampil kalau koleksi masih kosong --}}
        <div style="text-align:center; padding:3rem; color:#9ca3af;">
            <div style="font-size:3rem; margin-bottom:1rem;">📦</div>
            <p>Belum ada koleksi. Yuk tambahkan yang pertama!</p>
            <a href="{{ route('koleksi.create') }}" class="btn btn-primary" style="margin-top:1rem;">+ Tambah Sekarang</a>
        </div>

    @else
        {{-- Tabel koleksi --}}
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($koleksis as $koleksi)
                {{-- Loop: tampilkan satu baris per koleksi --}}
                <tr>
                    {{-- Kolom gambar --}}
                    <td>
                        @if ($koleksi->gambar)
                            <img src="{{ Storage::url($koleksi->gambar) }}"
                                 alt="{{ $koleksi->nama }}"
                                 class="koleksi-img">
                        @else
                            <div class="img-placeholder">
                                {{-- Emoji sesuai kategori --}}
                                @if($koleksi->kategori === 'game') 🎮
                                @elseif($koleksi->kategori === 'buku') 📚
                                @else 🎬
                                @endif
                            </div>
                        @endif
                    </td>

                    {{-- Kolom nama --}}
                    <td><strong>{{ $koleksi->nama }}</strong></td>

                    {{-- Kolom kategori dengan badge warna --}}
                    <td>
                        <span class="badge badge-{{ $koleksi->kategori }}">
                            {{ ucfirst($koleksi->kategori) }}
                        </span>
                    </td>

                    {{-- Kolom rating: tampilkan bintang --}}
                    <td>
                        <span class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= $koleksi->rating ? '★' : '☆' }}
                            @endfor
                        </span>
                    </td>

                    {{-- Kolom status dengan badge warna --}}
                    <td>
                        <span class="badge badge-{{ $koleksi->status }}">
                            {{ ucfirst($koleksi->status) }}
                        </span>
                    </td>

                    {{-- Kolom tombol aksi --}}
                    <td>
                        <div style="display:flex; gap:0.4rem; flex-wrap:wrap;">
                            <a href="{{ route('koleksi.show', $koleksi->id) }}" class="btn btn-info" style="padding:0.3rem 0.7rem;">👁</a>
                            <a href="{{ route('koleksi.edit', $koleksi->id) }}" class="btn btn-secondary" style="padding:0.3rem 0.7rem;">✏️</a>

                            {{-- Form hapus: DELETE butuh form POST dengan method spoofing --}}
                            <form action="{{ route('koleksi.destroy', $koleksi->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin mau hapus {{ $koleksi->nama }}?')">
                                @csrf
                                @method('DELETE')
                                {{-- @method('DELETE') = Laravel method spoofing, karena HTML form hanya bisa GET/POST --}}
                                <button type="submit" class="btn btn-danger" style="padding:0.3rem 0.7rem;">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Ringkasan statistik --}}
        <div style="display:flex; gap:1rem; margin-top:1.5rem; flex-wrap:wrap;">
            <div style="background:#f0f9ff; padding:0.7rem 1.2rem; border-radius:8px; font-size:0.85rem;">
                🎮 Game: <strong>{{ $koleksis->where('kategori','game')->count() }}</strong>
            </div>
            <div style="background:#f0fdf4; padding:0.7rem 1.2rem; border-radius:8px; font-size:0.85rem;">
                📚 Buku: <strong>{{ $koleksis->where('kategori','buku')->count() }}</strong>
            </div>
            <div style="background:#fdf2f8; padding:0.7rem 1.2rem; border-radius:8px; font-size:0.85rem;">
                🎬 Film: <strong>{{ $koleksis->where('kategori','film')->count() }}</strong>
            </div>
            <div style="background:#fefce8; padding:0.7rem 1.2rem; border-radius:8px; font-size:0.85rem;">
                💖 Wishlist: <strong>{{ $koleksis->where('status','wishlist')->count() }}</strong>
            </div>
        </div>
    @endif
</div>

@endsection