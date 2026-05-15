<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;    // ← untuk panggil API AI

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

        return redirect()->route('koleksi.index')
                         ->with('success', 'Koleksi berhasil dihapus!');
    }

    // Laravel AI Integration
    public function aiRekomendasi()
    {
        // Ambil semua koleksi milik user yang sedang login
        $koleksis = Koleksi::where('user_id', Auth::id())->get();
        // ↑ kita butuh data koleksi untuk dikirim ke AI

        // Siapkan ringkasan koleksi sebagai teks untuk AI
        // Format: "nama (kategori) - rating X/5 - status"
        $daftarKoleksi = $koleksis->map(function ($item) {
            return "- {$item->nama} ({$item->kategori}) | Rating: {$item->rating}/5 | Status: {$item->status}";
        })->implode("\n");
        // ↑ implode() = gabungkan semua baris jadi satu string

        // Kalau user belum punya koleksi, tampilkan pesan kosong
        if ($koleksis->isEmpty()) {
            return view('koleksi.ai', [
                'rekomendasi' => null,
                'koleksis'    => $koleksis,
                'pesan'       => 'Tambahkan dulu koleksimu agar AI bisa memberikan rekomendasi!',
            ]);
        }

        // Buat prompt yang akan dikirim ke AI
        $prompt = "Saya memiliki koleksi hobi berikut:\n{$daftarKoleksi}\n\n"
                . "Berdasarkan koleksi di atas, berikan 3 rekomendasi judul baru "
                . "(game, buku, atau film) yang mungkin saya sukai. "
                . "Jelaskan alasan singkat setiap rekomendasi. "
                . "Jawab dalam Bahasa Indonesia.";
        // ↑ prompt = instruksi yang kita kirim ke AI

        // Kirim data ke OpenRouter API (free, tidak butuh kartu kredit)
        // OpenRouter mendukung banyak model AI termasuk yang gratis
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            // ↑ API key disimpan di file .env agar tidak terekspos
            'HTTP-Referer'  => env('APP_URL', 'http://localhost'),
            'X-Title'       => 'Web Koleksi Hobi',
            'Content-Type'  => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'    => 'mistralai/mistral-7b-instruct:free',
            // ↑ model AI gratis dari Mistral via OpenRouter
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => 'Kamu adalah asisten yang membantu merekomendasikan game, buku, dan film.',
                ],
                [
                    'role'    => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);
        // ↑ Http::post() = kirim request HTTP POST ke API AI

        // Ambil teks rekomendasi dari response API
        $rekomendasi = null;
        if ($response->successful()) {
            // successful() = cek apakah API menjawab dengan status 200
            $rekomendasi = $response->json('choices.0.message.content');
            // ↑ ambil teks jawaban AI dari struktur JSON response
        }

        // Kirim data ke view untuk ditampilkan
        return view('koleksi.ai', [
            'rekomendasi' => $rekomendasi,
            'koleksis'    => $koleksis,
            'pesan'       => $rekomendasi ? null : 'Gagal menghubungi AI. Coba lagi nanti.',
        ]);
        // ↑ kalau $rekomendasi null = API gagal, tampilkan pesan error
    }
}