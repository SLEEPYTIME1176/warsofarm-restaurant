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
                <th>Alasan Batal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasis as $index => $item)
                <tr style="{{ in_array($item->status, ['done','cancelled']) ? 'opacity:0.55;' : '' }}">
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

                    {{-- Alasan Batal --}}
                    <td style="max-width:180px; font-size:12.5px; color:#721c24;">
                        @if($item->status === 'cancelled' && $item->alasan_batal)
                            {{ $item->alasan_batal }}
                        @else
                            <span style="color:#bbb;">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($item->status === 'confirmed')
                            <span class="badge" style="background:#d4edda; color:#155724; padding:4px 10px; border-radius:12px; font-size:12px;">Confirmed</span>
                        @elseif($item->status === 'done')
                            <span class="badge" style="background:#e8e8e8; color:#555; padding:4px 10px; border-radius:12px; font-size:12px;">Selesai</span>
                        @elseif($item->status === 'cancelled')
                            <span class="badge" style="background:#f8d7da; color:#721c24; padding:4px 10px; border-radius:12px; font-size:12px;">Cancelled</span>
                        @else
                            <span class="badge" style="background:#fff3cd; color:#856404; padding:4px 10px; border-radius:12px; font-size:12px;">Pending</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td>
                        @if(in_array($item->status, ['done', 'cancelled']))
                            <span style="color:#aaa;">—</span>
                        @else
                            <form action="{{ route('admin.reservasi.status', $item->id) }}" method="POST" id="form-status-{{ $item->id }}">
                                @csrf
                                <select name="status"
                                        id="status-{{ $item->id }}"
                                        onchange="onStatusChange{{ $item->id }}(this.value)"
                                        style="padding:6px 8px; border-radius:8px; border:1px solid #ddd; font-size:12px; width:100%; margin-bottom:6px;">
                                    <option value="pending"   {{ $item->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="confirmed" {{ $item->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                    <option value="done"      {{ $item->status == 'done' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>

                                <div id="batal-box-{{ $item->id }}" style="display:none;">
                                    <input type="text" name="alasan_batal" placeholder="Alasan pembatalan..." required
                                           style="width:100%; padding:6px 8px; border-radius:8px; border:1px solid #ddd; font-size:12px; margin-bottom:6px; box-sizing:border-box;">
                                    <button type="submit"
                                            style="width:100%; padding:6px; background:#3f2a20; color:white; border:none; border-radius:6px; font-size:12px; cursor:pointer;">
                                        Simpan
                                    </button>
                                </div>
                            </form>

                            <script>
                            function onStatusChange{{ $item->id }}(val) {
                                var box = document.getElementById('batal-box-{{ $item->id }}');
                                if (val === 'cancelled') {
                                    box.style.display = 'block';
                                } else {
                                    box.style.display = 'none';
                                    document.getElementById('form-status-{{ $item->id }}').submit();
                                }
                            }
                            </script>

                            <form action="{{ route('admin.reservasi.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus reservasi ini?')" style="margin-top:6px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="width:100%; padding:6px; background:#e74c3c; color:white; border:none; border-radius:6px; font-size:12px; cursor:pointer;">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:40px; color:#999;">
                        Belum ada data reservasi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection