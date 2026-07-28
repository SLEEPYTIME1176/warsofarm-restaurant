@extends('admin.layouts.app')

@section('content')
    <h1 class="page-title">Laporan</h1>

    <!-- Ringkasan -->
    <div class="stats" style="margin-bottom: 30px;">
        <div class="stat-card">
            <h3>Total Reservasi</h3>
            <p>{{ $totalReservasi }}</p>
        </div>
        <div class="stat-card">
            <h3>Pending</h3>
            <p style="color:#e67e22;">{{ $pending }}</p>
        </div>
        <div class="stat-card">
            <h3>Confirmed</h3>
            <p style="color:#27ae60;">{{ $confirmed }}</p>
        </div>
        <div class="stat-card">
            <h3>Cancelled</h3>
            <p style="color:#e74c3c;">{{ $cancelled }}</p>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:30px;">
        <!-- Info Tambahan -->
        <div class="card">
            <h2 style="font-size:17px; margin-bottom:20px;">Ringkasan Lainnya</h2>
            <table>
                <tr>
                    <td>Reservasi Bulan Ini</td>
                    <td style="text-align:right; font-weight:600;">{{ $bulanIni }}</td>
                </tr>
                <tr>
                    <td>Total Menu</td>
                    <td style="text-align:right; font-weight:600;">{{ $totalMenu }}</td>
                </tr>
                <tr>
                    <td>Menu Populer</td>
                    <td style="text-align:right; font-weight:600;">{{ $menuPopuler }}</td>
                </tr>
                <tr>
                    <td>Total Kategori</td>
                    <td style="text-align:right; font-weight:600;">{{ $totalKategori }}</td>
                </tr>
            </table>
        </div>

        <!-- Status Breakdown -->
        <div class="card">
            <h2 style="font-size:17px; margin-bottom:20px;">Status Reservasi</h2>
            @foreach($statusData as $status => $jumlah)
                <div style="margin-bottom:14px;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span>{{ $status }}</span>
                        <strong>{{ $jumlah }}</strong>
                    </div>
                    <div style="background:#eee; height:8px; border-radius:10px; overflow:hidden;">
                        @php
                            $persen = $totalReservasi > 0 ? ($jumlah / $totalReservasi * 100) : 0;
                        @endphp
                        <div style="height:100%; width:{{ $persen }}%; background:{{ $status == 'Pending' ? '#e67e22' : ($status == 'Confirmed' ? '#27ae60' : '#e74c3c') }};"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Reservasi Terbaru -->
    <div class="card">
        <h2 style="font-size:17px; margin-bottom:20px;">Reservasi Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentReservasi as $item)
                    <tr>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}</td>
                        <td>{{ $item->jumlah_orang }} Orang</td>
                        <td>
                            @if($item->status == 'pending')
                                <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:12px;">Pending</span>
                            @elseif($item->status == 'confirmed')
                                <span style="background:#d4edda; color:#155724; padding:3px 10px; border-radius:20px; font-size:12px;">Confirmed</span>
                            @else
                                <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:20px; font-size:12px;">Cancelled</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px; color:#999;">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection