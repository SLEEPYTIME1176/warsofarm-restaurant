@extends('admin.layouts.app')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
    <h1 class="page-title" style="margin:0;">Kelola Promo</h1>
    <a href="{{ route('admin.promo.create') }}" class="btn btn-primary">+ Tambah Promo</a>
</div>

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:14px 20px; border-radius:10px; margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kode</th>
                <th>Diskon</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promos as $promo)
                <tr>
                    <td>
                        <strong>{{ $promo->judul }}</strong>
                        @if($promo->gambar)
                            <br><img src="{{ asset('storage/'.$promo->gambar) }}" style="width:50px; height:35px; object-fit:cover; border-radius:6px; margin-top:4px;">
                        @endif
                    </td>
                    <td><code style="background:#f5f0eb; padding:3px 8px; border-radius:6px;">{{ $promo->kode_promo }}</code></td>
                    <td>
                        @if($promo->tipe == 'persen')
                            {{ $promo->nilai }}%
                        @else
                            Rp {{ number_format($promo->nilai, 0, ',', '.') }}
                        @endif
                    </td>
                    <td style="font-size:13px;">
                        {{ $promo->tanggal_mulai->format('d M Y') }}
                        <br>s/d {{ $promo->tanggal_selesai->format('d M Y') }}
                    </td>
                    <td>
                        @if($promo->isBerlaku())
                            <span style="background:#d4edda; color:#155724; padding:3px 10px; border-radius:20px; font-size:12px;">Aktif</span>
                        @elseif(!$promo->is_active)
                            <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:20px; font-size:12px;">Nonaktif</span>
                        @else
                            <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:12px;">Expired</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.promo.edit', $promo->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('admin.promo.destroy', $promo->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:#999;">Belum ada promo</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection