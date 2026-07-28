@extends('admin.layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 class="page-title" style="margin:0;">Data Pesanan</h1>
    </div>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:10px; margin-bottom:24px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Customer</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->kode_order }}</strong></td>
                        <td>
                            {{ $order->user->name ?? '-' }}<br>
                            <small style="color:#888;">{{ $order->user->email ?? '' }}</small>
                        </td>
                        <td>
                            @foreach($order->items as $item)
                                <div style="font-size:13px; margin-bottom:2px;">
                                    {{ $item->nama_produk }} × {{ $item->qty }}
                                </div>
                            @endforeach
                        </td>
                        <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                        <td>
                            @if($order->status == 'pending')
                                <span style="background:#fff3cd; color:#856404; padding:4px 10px; border-radius:20px; font-size:12px;">Pending</span>
                            @elseif($order->status == 'process')
                                <span style="background:#cce5ff; color:#004085; padding:4px 10px; border-radius:20px; font-size:12px;">Diproses</span>
                            @elseif($order->status == 'done')
                                <span style="background:#d4edda; color:#155724; padding:4px 10px; border-radius:20px; font-size:12px;">Selesai</span>
                            @else
                                <span style="background:#f8d7da; color:#721c24; padding:4px 10px; border-radius:20px; font-size:12px;">Dibatalkan</span>
                            @endif
                        </td>
                        <td style="font-size:13px;">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.order.status', $order->id) }}" method="POST" style="margin-bottom:6px;">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" style="padding:6px 10px; border-radius:8px; border:1px solid #ddd; font-size:13px;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </form>
                            <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#999;">Belum ada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection