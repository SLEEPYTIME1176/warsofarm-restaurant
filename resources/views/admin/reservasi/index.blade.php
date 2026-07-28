@extends('admin.layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 class="page-title" style="margin:0;">Data Reservasi</h1>
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
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Tanggal & Waktu</th>
                    <th>Jumlah</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasis as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->nama }}</strong></td>
                        <td>
                            @if($item->email) {{ $item->email }}<br> @endif
                            @if($item->telepon) {{ $item->telepon }} @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}<br>
                            <small>{{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}</small>
                        </td>
                        <td>{{ $item->jumlah_orang }} Orang</td>
                        <td>{{ $item->catatan ?? '-' }}</td>
                        <td>
                            @if($item->status == 'pending')
                                <span style="background:#fff3cd; color:#856404; padding:4px 10px; border-radius:20px; font-size:12px;">Pending</span>
                            @elseif($item->status == 'confirmed')
                                <span style="background:#d4edda; color:#155724; padding:4px 10px; border-radius:20px; font-size:12px;">Confirmed</span>
                            @else
                                <span style="background:#f8d7da; color:#721c24; padding:4px 10px; border-radius:20px; font-size:12px;">Cancelled</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.reservasi.status', $item->id) }}" method="POST" style="display:inline-block; margin-bottom:6px;">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" style="padding:6px 10px; border-radius:8px; border:1px solid #ddd; font-size:13px;">
                                    <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $item->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                            <br>
                            <form action="{{ route('admin.reservasi.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus reservasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-top:4px;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px; color:#999;">Belum ada data reservasi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection