<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;      // ← tambahkan baris ini
use Illuminate\Support\Facades\Storage;

class KoleksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $koleksis = Koleksi::where('user_id', Auth::id())
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('kategori', 'like', '%' . $search . '%')
                      ->orWhere('catatan', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        return view('koleksi.index', compact('koleksis', 'search'));
    }

    public function create()
    {
        return view('koleksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'required|string|in:game,buku,film',
            'rating'   => 'required|integer|min:1|max:5',
            'catatan'  => 'nullable|string',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('koleksi', 'public');
        }

        Koleksi::create([
            'user_id'  => Auth::id(),
            'nama'     => $request->nama,
            'kategori' => $request->kategori,
            'rating'   => $request->rating,
            'status'   => 'dimiliki',
            'catatan'  => $request->catatan,
            'gambar'   => $gambarPath,
        ]);

        return redirect()->route('koleksi.index')
            ->with('success', 'Koleksi berhasil ditambahkan.');
    }

    public function show(Koleksi $koleksi)
    {
        Gate::authorize('view', $koleksi);
        return view('koleksi.show', compact('koleksi'));
    }

    public function edit(Koleksi $koleksi)
    {
        Gate::authorize('update', $koleksi);
        return view('koleksi.edit', compact('koleksi'));
    }

    public function update(Request $request, Koleksi $koleksi)
    {
        Gate::authorize('update', $koleksi);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'required|string|in:game,buku,film',
            'rating'   => 'required|integer|min:1|max:5',
            'catatan'  => 'nullable|string',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = $koleksi->gambar;

        if ($request->hasFile('gambar')) {
            if ($koleksi->gambar) {
                Storage::disk('public')->delete($koleksi->gambar);
            }
            $gambarPath = $request->file('gambar')->store('koleksi', 'public');
        }

        $koleksi->update([
            'nama'     => $request->nama,
            'kategori' => $request->kategori,
            'rating'   => $request->rating,
            'catatan'  => $request->catatan,
            'gambar'   => $gambarPath,
        ]);

        return redirect()->route('koleksi.index')
            ->with('success', 'Koleksi berhasil diperbarui.');
    }

    public function destroy(Koleksi $koleksi)
    {
        Gate::authorize('delete', $koleksi);

        if ($koleksi->gambar) {
            Storage::disk('public')->delete($koleksi->gambar);
        }

        $koleksi->delete();

        return redirect()->route('koleksi.index')
            ->with('success', 'Koleksi berhasil dihapus.');
    }

    public function filter($kategori)
    {
        $koleksis = Koleksi::where('user_id', Auth::id())
            ->where('kategori', $kategori)
            ->latest()
            ->get();

        return view('koleksi.filter', compact('koleksis', 'kategori'));
    }

    public function profile()
    {
        $totalKoleksi = Koleksi::where('user_id', Auth::id())->count();
        $totalGame    = Koleksi::where('user_id', Auth::id())->where('kategori', 'game')->count();
        $totalBuku    = Koleksi::where('user_id', Auth::id())->where('kategori', 'buku')->count();
        $totalFilm    = Koleksi::where('user_id', Auth::id())->where('kategori', 'film')->count();

        return view('koleksi.profile', compact('totalKoleksi', 'totalGame', 'totalBuku', 'totalFilm'));
    }

    // =========================================================
    // MODUL 7 — AI Rekomendasi Hobi
    // =========================================================

    public function aiRekomendasi()
    {
        // 1. Ambil semua koleksi milik user yang sedang login
        $koleksis = Koleksi::where('user_id', Auth::id())->get();

        // 2. Kalau koleksi masih kosong, tidak perlu panggil API
        if ($koleksis->isEmpty()) {
            return view('koleksi.ai', [
                'analisis' => null,
                'pesan'    => 'Tambahkan dulu koleksimu agar AI bisa menganalisis hobimu!',
            ]);
        }

        // 3. Hitung ringkasan koleksi per kategori untuk dikirim ke AI
        $totalGame  = $koleksis->where('kategori', 'game')->count();
        $totalBuku  = $koleksis->where('kategori', 'buku')->count();
        $totalFilm  = $koleksis->where('kategori', 'film')->count();

        // 4. Buat daftar nama koleksi sebagai konteks tambahan untuk AI
        $daftarNama = $koleksis->pluck('nama')->implode(', ');
        // pluck('nama') = ambil hanya kolom nama → implode = gabung jadi satu string

        // 5. Susun prompt yang dikirim ke AI
        $prompt = "Seorang pengguna memiliki koleksi hobi berikut:\n"
                . "- Game   : {$totalGame} koleksi\n"
                . "- Film   : {$totalFilm} koleksi\n"
                . "- Buku   : {$totalBuku} koleksi\n"
                . "Judul koleksinya antara lain: {$daftarNama}.\n\n"
                . "Berdasarkan data di atas, buat 1 paragraf analisis singkat tentang kepribadian "
                . "dan karakter hobi pengguna ini. Kemudian berikan 1 rekomendasi spesifik "
                . "untuk masing-masing kategori (game, film, buku) lengkap dengan alasan singkat "
                . "mengapa cocok untuknya. Jawab dalam Bahasa Indonesia, santai, dan menyenangkan.";

        // 6. Kirim prompt ke Groq API (gratis, cepat)
        $analisis   = null;
        $pesanError = null;

        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'    => 'llama-3.1-8b-instant',
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' => 'Kamu adalah asisten analisis hobi yang ramah dan suportif. '
                                   . 'Berikan analisis dan rekomendasi yang personal dan menyenangkan.',
                    ],
                    [
                        'role'    => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens'  => 1024,
                'temperature' => 0.7,
            ]);

            // 7. Ambil teks jawaban dari response Groq
            // Struktur sama seperti OpenAI: choices → [0] → message → content
            if ($response->successful()) {
                $analisis = $response->json('choices.0.message.content');
            } else {
                $errMsg     = $response->json('error.message', 'Unknown error');
                $pesanError = 'Groq error ' . $response->status() . ': ' . $errMsg;
            }

        } catch (\Exception $e) {
            $pesanError = 'Koneksi gagal: ' . $e->getMessage();
        }

        // 8. Kirim ke view untuk ditampilkan
        return view('koleksi.ai', [
            'analisis'  => $analisis,
            'koleksis'  => $koleksis,
            'totalGame' => $totalGame,
            'totalBuku' => $totalBuku,
            'totalFilm' => $totalFilm,
            'pesan'     => $analisis ? null : ($pesanError ?? 'Gagal menghubungi AI. Periksa API key di .env atau coba lagi nanti.'),
        ]);
    }
}