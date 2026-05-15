@extends('koleksi.layout')

@section('title', 'Tambah Koleksi')

@section('content')

<div class="card">
    <div class="card-title">➕ Tambah Koleksi Baru</div>

    {{-- Form tambah koleksi --}}
    {{-- enctype="multipart/form-data" wajib ada kalau form ada upload file/gambar --}}
    <form action="{{ route('koleksi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @csrf = token keamanan Laravel, WAJIB ada di setiap form POST --}}

        {{-- Nama koleksi --}}
        <div class="form-group">
            <label for="nama">Nama Koleksi <span style="color:red">*</span></label>
            <input type="text" id="nama" name="nama"
                   value="{{ old('nama') }}"
                   placeholder="Contoh: Elden Ring, Atomic Habits, Interstellar..."
                   class="{{ $errors->has('nama') ? 'is-invalid' : '' }}">
            {{-- old('nama') = isi ulang nilai input kalau form gagal validasi --}}
            @error('nama')
                <div class="invalid-feedback">⚠ {{ $message }}</div>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="form-group">
            <label for="kategori">Kategori <span style="color:red">*</span></label>
            <select id="kategori" name="kategori">
                <option value="">-- Pilih Kategori --</option>
                <option value="game"  {{ old('kategori') === 'game'  ? 'selected' : '' }}>🎮 Game</option>
                <option value="buku"  {{ old('kategori') === 'buku'  ? 'selected' : '' }}>📚 Buku</option>
                <option value="film"  {{ old('kategori') === 'film'  ? 'selected' : '' }}>🎬 Film</option>
            </select>
            @error('kategori')
                <div class="invalid-feedback">⚠ {{ $message }}</div>
            @enderror
        </div>

        {{-- Rating --}}
        <div class="form-group">
            <label for="rating">Rating (1–5) <span style="color:red">*</span></label>
            <select id="rating" name="rating">
                <option value="">-- Pilih Rating --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                        {{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }} ({{ $i }})
                    </option>
                @endfor
            </select>
            @error('rating')
                <div class="invalid-feedback">⚠ {{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="form-group">
            <label for="status">Status <span style="color:red">*</span></label>
            <select id="status" name="status">
                <option value="">-- Pilih Status --</option>
                <option value="dimiliki" {{ old('status') === 'dimiliki' ? 'selected' : '' }}>✅ Sudah Dimiliki</option>
                <option value="wishlist" {{ old('status') === 'wishlist' ? 'selected' : '' }}>💖 Wishlist</option>
            </select>
            @error('status')
                <div class="invalid-feedback">⚠ {{ $message }}</div>
            @enderror
        </div>

        {{-- Catatan (opsional) --}}
        <div class="form-group">
            <label for="catatan">Catatan <span style="color:#9ca3af; font-weight:400">(opsional)</span></label>
            <textarea id="catatan" name="catatan" placeholder="Tulis pendapat atau catatan singkat...">{{ old('catatan') }}</textarea>
            @error('catatan')
                <div class="invalid-feedback">⚠ {{ $message }}</div>
            @enderror
        </div>

        {{-- Gambar (opsional) --}}
        <div class="form-group">
            <label for="gambar">Gambar Cover <span style="color:#9ca3af; font-weight:400">(opsional, maks 2MB)</span></label>
            <input type="file" id="gambar" name="gambar" accept="image/*">
            @error('gambar')
                <div class="invalid-feedback">⚠ {{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol aksi --}}
        <div style="display:flex; gap:0.8rem; margin-top:1.5rem;">
            <button type="submit" class="btn btn-primary">💾 Simpan Koleksi</button>
            <a href="{{ route('koleksi.index') }}" class="btn btn-secondary">← Kembali</a>
        </div>
    </form>
</div>

@endsection