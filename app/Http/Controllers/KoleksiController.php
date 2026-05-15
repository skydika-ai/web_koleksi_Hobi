<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KoleksiController extends Controller
{
    public function index()
    {
        // Ambil semua koleksi milik user yang sedang login
        $koleksis = Koleksi::where('user_id', Auth::id())->get();
        // ↑ Auth::id() = id user yang sedang login
        // where() = filter hanya koleksi milik dia

        return view('koleksi.index', compact('koleksis'));
        // ↑ kirim data $koleksis ke halaman view koleksi/index.blade.php
    }

    public function create()
    {
        return view('koleksi.create');
        // ↑ tampilkan halaman form tambah koleksi
    }

    public function store(Request $request)
    {
        // Validasi semua input dari form
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'required|in:game,buku,film',
            'rating'   => 'required|integer|min:1|max:5',
            'status'   => 'required|in:dimiliki,wishlist',
            'catatan'  => 'nullable|string',
            'gambar'   => 'nullable|image|max:2048',
            // ↑ gambar boleh kosong, kalau diisi harus file gambar, max 2MB
        ]);

        // Proses upload gambar kalau ada
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')
                                  ->store('koleksi', 'public');
            // ↑ simpan gambar ke folder storage/app/public/koleksi
        }

        // Simpan data koleksi baru ke database
        Koleksi::create([
            'user_id'  => Auth::id(),
            // ↑ otomatis isi user_id dengan id user yang login
            'nama'     => $request->nama,
            'kategori' => $request->kategori,
            'rating'   => $request->rating,
            'status'   => $request->status,
            'catatan'  => $request->catatan,
            'gambar'   => $gambarPath,
        ]);

        return redirect()->route('koleksi.index')
                         ->with('success', 'Koleksi berhasil ditambahkan!');
        // ↑ setelah simpan, kembali ke halaman daftar koleksi
        // with('success') = kirim pesan sukses untuk ditampilkan
    }

    public function show(Koleksi $koleksi)
    {
        return view('koleksi.show', compact('koleksi'));
        // ↑ tampilkan halaman detail satu koleksi
    }

    public function edit(Koleksi $koleksi)
    {
        return view('koleksi.edit', compact('koleksi'));
        // ↑ tampilkan halaman form edit koleksi
    }

    public function update(Request $request, Koleksi $koleksi)
    {
        // Validasi input
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'required|in:game,buku,film',
            'rating'   => 'required|integer|min:1|max:5',
            'status'   => 'required|in:dimiliki,wishlist',
            'catatan'  => 'nullable|string',
            'gambar'   => 'nullable|image|max:2048',
        ]);

        // Proses upload gambar baru kalau ada
        $gambarPath = $koleksi->gambar;
        // ↑ default pakai gambar lama

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama kalau ada
            if ($koleksi->gambar) {
                Storage::disk('public')->delete($koleksi->gambar);
            }
            $gambarPath = $request->file('gambar')
                                ->store('koleksi', 'public');
        }

        // Update data di database
        $koleksi->update([
            'nama'     => $request->nama,
            'kategori' => $request->kategori,
            'rating'   => $request->rating,
            'status'   => $request->status,
            'catatan'  => $request->catatan,
            'gambar'   => $gambarPath,
        ]);

        return redirect()->route('koleksi.index')
                    ->with('success', 'Koleksi berhasil diupdate!');
    }

    public function destroy(Koleksi $koleksi)
    {
        // Hapus gambar dari storage kalau ada
        if ($koleksi->gambar) {
            Storage::disk('public')->delete($koleksi->gambar);
        }

        // Hapus data dari database
        $koleksi->delete();

        return redirect()->route('koleksi.index') ->with('success', 'Koleksi berhasil dihapus!');
    }
}