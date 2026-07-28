<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Warso Restaurant</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f5f5; color: #333; }

        .admin-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #3f2a20;
            color: white;
            padding: 30px 0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 100;
        }
        .sidebar .brand {
            padding: 0 28px 30px;
            font-size: 22px;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            padding: 14px 28px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 14.5px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .sidebar button {
            background: none;
            border: none;
            color: rgba(255,255,255,0.75);
            padding: 14px 28px;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 14.5px;
            font-family: inherit;
        }
        .sidebar button:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        /* Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 40px;
            min-height: 100vh;
        }
        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #3f2a20;
            margin-bottom: 28px;
        }

        /* Common */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13.5px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary { background: #9c5638; color: white; }
        .btn-primary:hover { background: #7d432c; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-sm { padding: 7px 14px; font-size: 13px; }

        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            text-align: left;
            padding: 12px 14px;
            border-bottom: 2px solid #f0e6d8;
            color: #888;
            font-size: 13px;
            font-weight: 600;
        }
        table td {
            padding: 14px;
            border-bottom: 1px solid #f5f0eb;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="brand">Warso Admin</div>

            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.produk.index') }}" class="{{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                Kelola Menu
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                Kelola Kategori
            </a>
            <a href="{{ route('admin.promo.index') }}" class="{{ request()->routeIs('admin.promo.*') ? 'active' : '' }}">
                Kelola Promo
            </a>
            <a href="{{ route('admin.order.index') }}" class="{{ request()->routeIs('admin.order.*') ? 'active' : '' }}">
                Data Pesanan
            </a>
            <a href="{{ route('admin.reservasi.index') }}" class="{{ request()->routeIs('admin.reservasi.*') ? 'active' : '' }}">
                Data Reservasi
                @php
                    $pendingCount = \App\Models\Reservasi::where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span style="background:#e74c3c; color:white; font-size:11px; padding:2px 7px; border-radius:20px; margin-left:6px;">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                Laporan
            </a>

            <div style="margin-top:30px; border-top:1px solid rgba(255,255,255,0.1); padding-top:10px;">
                <a href="/" target="_blank">Lihat Website</a>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</body>
</html>