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
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promos as $promo)
                <tr>
                    <td>
                        <strong>{{ $promo->judul }}</strong>
                        @if($promo->gambar)
                            <br>
                            <img src="{{ asset('storage/'.$promo->gambar) }}"
                                 style="width:50px; height:35px; object-fit:cover; border-radius:6px; margin-top:4px;"
                                 alt="">
                        @endif
                    </td>
                    <td>
                        <code style="background:#f5f0eb; padding:3px 8px; border-radius:6px;">
                            {{ $promo->kode_promo }}
                        </code>
                    </td>
                    <td>
                        @if($promo->tipe == 'persen')
                            {{ $promo->nilai }}%
                        @else
                            Rp {{ number_format($promo->nilai, 0, ',', '.') }}
                        @endif
                    </td>
                    <td style="font-size:13px;">
                        {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}
                        <br>s/d {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
                    </td>
                    <td>
                        @if(method_exists($promo, 'isBerlaku') && $promo->isBerlaku())
                            <span style="background:#d4edda; color:#155724; padding:3px 10px; border-radius:20px; font-size:12px;">Aktif</span>
                        @elseif(!$promo->is_active)
                            <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:20px; font-size:12px;">Nonaktif</span>
                        @else
                            <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:12px;">Expired</span>
                        @endif
                    </td>
                    <td>
                        @if($promo->kuota)
                            <span style="font-weight:600; color:#3f2a20;">
                                {{ $promo->terpakai ?? 0 }} / {{ $promo->kuota }}
                            </span>
                            @php $sisa = $promo->kuota - ($promo->terpakai ?? 0); @endphp
                            @if($sisa <= 0)
                                <div style="font-size:11px; color:#c0392b; margin-top:2px;">Habis</div>
                            @elseif($sisa <= 5)
                                <div style="font-size:11px; color:#e67e22; margin-top:2px;">Sisa {{ $sisa }}</div>
                            @endif
                        @else
                            <span style="color:#aaa;">∞</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.promo.edit', $promo->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('admin.promo.destroy', $promo->id) }}" method="POST"
                              style="display:inline;"
                              onsubmit="return confirmHapusPromo(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background:#c0392b; color:white; border:none; padding:6px 12px; border-radius:8px; font-size:12px; cursor:pointer;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px; color:#999;">Belum ada promo</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal hapus promo --}}
<div id="hapus-promo-modal"
     style="display:none; position:fixed; inset:0; background:rgba(63,42,32,0.35); z-index:9998; align-items:center; justify-content:center;">
    <div style="background:#fffaf0; border-radius:16px; padding:28px 24px; max-width:340px; width:90%; box-shadow:0 16px 48px rgba(0,0,0,0.15); text-align:center;">
        <div style="font-size:28px; margin-bottom:12px;">🗑️</div>
        <p style="font-size:15px; color:#3f2a20; margin:0 0 8px; font-weight:600;">Hapus promo ini?</p>
        <p style="font-size:13px; color:#8b7355; margin:0 0 22px; line-height:1.5;">Data promo yang dihapus tidak bisa dikembalikan.</p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button type="button" id="hapus-promo-no"
                    style="flex:1; padding:10px; border-radius:10px; border:1px solid #e8ddd0; background:white; color:#3f2a20; font-size:13px; cursor:pointer; font-family:inherit;">
                Batal
            </button>
            <button type="button" id="hapus-promo-yes"
                    style="flex:1; padding:10px; border-radius:10px; border:none; background:#c0392b; color:white; font-size:13px; cursor:pointer; font-family:inherit;">
                Ya, hapus
            </button>
        </div>
    </div>
</div>

<script>
var __hapusPromoForm = null;

function confirmHapusPromo(e, form) {
    e.preventDefault();
    __hapusPromoForm = form;
    document.getElementById('hapus-promo-modal').style.display = 'flex';
    return false;
}

document.getElementById('hapus-promo-no')?.addEventListener('click', function () {
    document.getElementById('hapus-promo-modal').style.display = 'none';
    __hapusPromoForm = null;
});

document.getElementById('hapus-promo-yes')?.addEventListener('click', function () {
    document.getElementById('hapus-promo-modal').style.display = 'none';
    if (__hapusPromoForm) __hapusPromoForm.submit();
});
</script>
@endsection