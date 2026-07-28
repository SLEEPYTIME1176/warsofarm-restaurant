@extends('admin.layouts.app')

@section('content')
<style>
    .dash-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .dash-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
    .dash-card .label {
        font-size: 13px;
        color: #888;
        margin-bottom: 8px;
    }
    .dash-card .value {
        font-size: 26px;
        font-weight: 700;
        color: #3f2a20;
    }
    .dash-card .value.green { color: #27ae60; }
    .dash-card .value.orange { color: #e67e22; }
    .dash-card .value.blue { color: #2980b9; }
    .dash-card .value.red { color: #e74c3c; }

    .section-box {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        margin-bottom: 24px;
    }
    .section-box h3 {
        font-size: 16px;
        margin-bottom: 18px;
        color: #3f2a20;
    }

    .two-col {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    table.dash-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }
    table.dash-table th {
        text-align: left;
        padding: 10px 8px;
        border-bottom: 2px solid #f0e6d8;
        color: #888;
        font-weight: 600;
        font-size: 12px;
    }
    table.dash-table td {
        padding: 12px 8px;
        border-bottom: 1px solid #f5f0eb;
    }

    .badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-process { background: #cce5ff; color: #004085; }
    .badge-done { background: #d4edda; color: #155724; }
    .badge-cancelled { background: #f8d7da; color: #721c24; }

    .status-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }
    .status-bar .bar {
        flex: 1;
        height: 8px;
        background: #f0e6d8;
        border-radius: 10px;
        overflow: hidden;
    }
    .status-bar .bar-fill {
        height: 100%;
        border-radius: 10px;
    }

    @media (max-width: 1100px) {
        .dash-grid { grid-template-columns: repeat(2, 1fr); }
        .two-col { grid-template-columns: 1fr; }
    }
</style>

<h1 class="page-title" style="margin-bottom:28px;">Dashboard</h1>

{{-- ===== STATS PENDAPATAN ===== --}}
<div class="dash-grid">
    <div class="dash-card">
        <div class="label">Pendapatan Hari Ini</div>
        <div class="value green">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
    </div>
    <div class="dash-card">
        <div class="label">Pendapatan Bulan Ini</div>
        <div class="value blue">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
    </div>
    <div class="dash-card">
        <div class="label">Total Pendapatan</div>
        <div class="value">Rp {{ number_format($pendapatanTotal, 0, ',', '.') }}</div>
    </div>
    <div class="dash-card">
        <div class="label">Pesanan Pending</div>
        <div class="value orange">{{ $pesananPending }}</div>
    </div>
</div>

{{-- ===== STATS LAIN ===== --}}
<div class="dash-grid">
    <div class="dash-card">
        <div class="label">Total Pesanan</div>
        <div class="value">{{ $totalPesanan }}</div>
    </div>
    <div class="dash-card">
        <div class="label">Total Menu</div>
        <div class="value">{{ $totalMenu }}</div>
    </div>
    <div class="dash-card">
        <div class="label">Total User</div>
        <div class="value">{{ $totalUser }}</div>
    </div>
    <div class="dash-card">
        <div class="label">Reservasi Pending</div>
        <div class="value red">{{ $reservasiPending }}</div>
    </div>
</div>

{{-- ===== GRAFIK + STATUS ===== --}}
<div class="two-col">
    <div class="section-box">
        <h3>Grafik Penjualan 7 Hari Terakhir</h3>
        <canvas id="salesChart" height="200"></canvas>
    </div>

    <div class="section-box">
        <h3>Status Pesanan</h3>
        @php $total = max($totalPesanan, 1); @endphp

        <div class="status-bar">
            <span style="width:80px; font-size:13px;">Pending</span>
            <div class="bar"><div class="bar-fill" style="width:{{ ($pesananPending/$total)*100 }}%; background:#f39c12;"></div></div>
            <strong style="width:30px; text-align:right;">{{ $pesananPending }}</strong>
        </div>
        <div class="status-bar">
            <span style="width:80px; font-size:13px;">Diproses</span>
            <div class="bar"><div class="bar-fill" style="width:{{ ($pesananProcess/$total)*100 }}%; background:#3498db;"></div></div>
            <strong style="width:30px; text-align:right;">{{ $pesananProcess }}</strong>
        </div>
        <div class="status-bar">
            <span style="width:80px; font-size:13px;">Selesai</span>
            <div class="bar"><div class="bar-fill" style="width:{{ ($pesananDone/$total)*100 }}%; background:#27ae60;"></div></div>
            <strong style="width:30px; text-align:right;">{{ $pesananDone }}</strong>
        </div>
        <div class="status-bar">
            <span style="width:80px; font-size:13px;">Batal</span>
            <div class="bar"><div class="bar-fill" style="width:{{ ($pesananCancelled/$total)*100 }}%; background:#e74c3c;"></div></div>
            <strong style="width:30px; text-align:right;">{{ $pesananCancelled }}</strong>
        </div>

        <h3 style="margin-top:28px;">Top Menu</h3>
        @forelse($topMenu as $item)
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f5f0eb; font-size:13.5px;">
                <span>{{ $item->nama_produk }}</span>
                <strong>{{ $item->total_qty }}x</strong>
            </div>
        @empty
            <p style="color:#999; font-size:13px;">Belum ada data</p>
        @endforelse
    </div>
</div>

{{-- ===== PESANAN TERBARU ===== --}}
<div class="section-box">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <h3 style="margin:0;">Pesanan Terbaru</h3>
        <a href="{{ route('admin.order.index') }}" style="font-size:13px; color:#9c5638;">Lihat Semua →</a>
    </div>
    <table class="dash-table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesananTerbaru as $order)
                <tr>
                    <td><strong>{{ $order->kode_order }}</strong></td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="badge badge-pending">Pending</span>
                        @elseif($order->status == 'process')
                            <span class="badge badge-process">Diproses</span>
                        @elseif($order->status == 'done')
                            <span class="badge badge-done">Selesai</span>
                        @else
                            <span class="badge badge-cancelled">Batal</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center; color:#999; padding:30px;">Belum ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($chartData) !!},
            backgroundColor: 'rgba(156, 86, 56, 0.7)',
            borderColor: '#9c5638',
            borderWidth: 1,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endsection