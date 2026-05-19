<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Koleksi Hobi')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6fb;
            color: #1a1a2e;
            min-height: 100vh;
        }

        /* ===== NAVBAR ===== */
        nav {
            background: #1a1a2e;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        nav .brand {
            color: #e94560;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
        }

        nav .nav-links {
            display: flex;
            align-items: center;
        }

        nav .nav-links a {
            color: #a8b2d8;
            text-decoration: none;
            margin-left: 1.5rem;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        nav .nav-links a:hover { color: #e94560; }

        /* Link AI warna ungu */
        nav .nav-links .link-ai {
            color: #c4b5fd;
        }
        nav .nav-links .link-ai:hover { color: #a78bfa; }

        /* Link Admin warna kuning */
        nav .nav-links .link-admin {
            color: #fbbf24;
        }
        nav .nav-links .link-admin:hover { color: #f59e0b; }

        /* Badge role kecil di sebelah nama user */
        .badge-role {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            margin-left: 0.4rem;
            vertical-align: middle;
        }
        .badge-role.admin { background: #fbbf24; color: #1a1a2e; }
        .badge-role.user  { background: #374151; color: #9ca3af; }

        /* Nama user di navbar */
        .nav-user {
            color: #e2e8f0 !important;
            font-size: 0.85rem !important;
            cursor: default;
        }
        .nav-user:hover { color: #e2e8f0 !important; }

        nav .nav-links .btn-logout {
            background: #e94560;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            margin-left: 1.5rem;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        nav .nav-links .btn-logout:hover { background: #c73652; }

        /* ===== CONTAINER ===== */
        .container {
            max-width: 960px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* ===== ALERT ===== */
        .alert {
            padding: 0.85rem 1.2rem;
            border-radius: 8px;
            margin-bottom: 1.2rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* ===== CARD ===== */
        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid #e94560;
        }

        /* ===== TOMBOL ===== */
        .btn {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary   { background: #e94560; color: white; }
        .btn-primary:hover { background: #c73652; }

        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #545b62; }

        .btn-danger    { background: #dc3545; color: white; }
        .btn-danger:hover { background: #b02a37; }

        .btn-info      { background: #0ea5e9; color: white; }
        .btn-info:hover { background: #0284c7; }

        .btn-ai        { background: #7c3aed; color: white; }
        .btn-ai:hover  { background: #6d28d9; }

        .btn-admin     { background: #d97706; color: white; }
        .btn-admin:hover { background: #b45309; }

        /* ===== FORM ===== */
        .form-group { margin-bottom: 1rem; }

        label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 0.55rem 0.9rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #1a1a2e;
            background: #f9fafb;
            transition: border 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #e94560;
            background: white;
        }

        textarea { resize: vertical; min-height: 80px; }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        thead th {
            background: #1a1a2e;
            color: white;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
        }

        tbody tr:hover { background: #f9fafb; }

        tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-game    { background: #dbeafe; color: #1e40af; }
        .badge-buku    { background: #d1fae5; color: #065f46; }
        .badge-film    { background: #fce7f3; color: #9d174d; }
        .badge-dimiliki{ background: #d1fae5; color: #065f46; }
        .badge-wishlist{ background: #fef3c7; color: #92400e; }
        .badge-admin   { background: #fef3c7; color: #92400e; }
        .badge-user    { background: #f1f5f9; color: #64748b; }

        /* ===== BINTANG ===== */
        .stars { color: #f59e0b; letter-spacing: 2px; }

        /* ===== GAMBAR KOLEKSI ===== */
        .koleksi-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .img-placeholder {
            width: 50px;
            height: 50px;
            background: #e5e7eb;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        /* ===== AI BOX ===== */
        .ai-box {
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            line-height: 1.8;
            white-space: pre-wrap;
            font-size: 0.95rem;
        }

        .ai-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 1rem;
            font-weight: 700;
            color: #c4b5fd;
        }
    </style>
</head>
<body>

{{-- ===== NAVBAR ===== --}}
<nav>
    <a href="{{ route('koleksi.index') }}" class="brand">🎮 KoleksiFlix</a>

    <div class="nav-links">

        {{-- Menu utama --}}
        <a href="{{ route('koleksi.index') }}">Koleksiku</a>
        <a href="{{ route('koleksi.create') }}">+ Tambah</a>
        <a href="{{ route('koleksi.ai') }}" class="link-ai">✨ AI Rekomendasi</a>

        {{-- Menu Admin: hanya muncul kalau role = admin --}}
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.index') }}" class="link-admin">🛡 Admin Panel</a>
        @endif

        {{-- Nama user + badge role --}}
        <span class="nav-user">
            {{ Auth::user()->name }}
            @if(Auth::user()->isAdmin())
                <span class="badge-role admin">Admin</span>
            @else
                <span class="badge-role user">User</span>
            @endif
        </span>

        {{-- Tombol logout --}}
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>

    </div>
</nav>

{{-- ===== KONTEN UTAMA ===== --}}
<div class="container">

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- Konten tiap halaman mengisi bagian ini --}}
    @yield('content')

</div>

</body>
</html>