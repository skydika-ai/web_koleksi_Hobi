<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua user beserta jumlah koleksinya sekaligus
        // withCount() = tambahkan kolom koleksis_count otomatis
        $users = User::withCount('koleksis')->latest()->get();

        // Statistik global untuk kartu ringkasan di atas halaman
        $totalUsers    = User::count();
        $totalKoleksi  = Koleksi::count();
        $totalGame     = Koleksi::where('kategori', 'game')->count();
        $totalBuku     = Koleksi::where('kategori', 'buku')->count();
        $totalFilm     = Koleksi::where('kategori', 'film')->count();

        return view('admin.index', compact(
            'users',
            'totalUsers',
            'totalKoleksi',
            'totalGame',
            'totalBuku',
            'totalFilm'
        ));
    }

    public function destroyUser(User $user)
    {
        // Jangan sampai admin menghapus akun dirinya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        // Hapus user → koleksinya ikut terhapus otomatis karena
        // di migration koleksis ada onDelete('cascade')
        $user->delete();

        return back()->with('success', "Akun {$user->name} berhasil dihapus.");
    }

    public function destroyKoleksi(Koleksi $koleksi)
    {
        // Admin bisa hapus koleksi milik siapapun
        if ($koleksi->gambar) {
            Storage::disk('public')->delete($koleksi->gambar);
        }

        $koleksi->delete();

        return back()->with('success', "Koleksi \"{$koleksi->nama}\" berhasil dihapus.");
    }
}