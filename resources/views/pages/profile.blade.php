@extends('layouts.app')

@section('content')
<div class="container" style="padding: 50px 24px 80px;">
    <div class="section-header">
        <h2>Edit Profil</h2>
        <p>Kelola informasi akunmu</p>
    </div>

    @if(session('success'))
        <div style="max-width:520px; margin:0 auto 20px; background:#d4edda; color:#155724; padding:14px 18px; border-radius:12px; text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-card">
        <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Avatar --}}
            <div class="avatar-section">
                <div class="avatar-wrap" id="avatarPreview" onclick="openPhotoModal()">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="Avatar" id="avatarImg">
                    @else
                        <div class="avatar-initial" id="avatarInitial">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <label class="avatar-cam" onclick="event.stopPropagation(); document.getElementById('avatarInput').click();">
                        📷
                    </label>
                </div>
                <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">

                @if(auth()->user()->avatar)
                    <label class="hapus-foto">
                        <input type="checkbox" name="hapus_foto" value="1"> Hapus foto profil
                    </label>
                @endif
                <p class="avatar-hint">Klik foto untuk perbesar · Klik 📷 untuk ganti (max 2MB)</p>
            </div>

            {{-- Member sejak --}}
            <div class="member-since">
                🌿 Member sejak {{ auth()->user()->created_at->translatedFormat('d F Y') }}
            </div>

            {{-- Nama --}}
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            {{-- No HP --}}
            <div class="form-group">
                <label>No. Handphone</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}"
                       placeholder="08xxxxxxxxxx">
            </div>

            {{-- Alamat --}}
            <div class="form-group">
                <label>Alamat Default</label>
                <textarea name="alamat" rows="3" placeholder="Alamat pengiriman / kedatangan...">{{ old('alamat', auth()->user()->alamat) }}</textarea>
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label>Password Baru <span style="font-weight:400; color:#999;">(opsional)</span></label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
            </div>

            {{-- Tombol --}}
            <div class="profile-actions">
                <button type="button" onclick="confirmSave()" class="btn btn-primary" style="flex:1; padding:14px;">
                    Simpan Perubahan
                </button>
                <a href="{{ route('riwayat') }}" class="btn" style="flex:1; padding:14px; text-align:center; background:#f8f1e9; color:#9c5638; border-radius:12px; font-weight:600; text-decoration:none;">
                    📋 Pesanan Saya
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Modal foto besar --}}
<div id="photoModal" class="photo-modal" onclick="closePhotoModal()">
    <div class="photo-modal-inner" onclick="event.stopPropagation()">
        <button type="button" class="photo-close" onclick="closePhotoModal()">✕</button>
        @if(auth()->user()->avatar)
            <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="Foto profil" id="modalPhoto">
        @else
            <div class="photo-modal-initial">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        @endif
        <p>{{ auth()->user()->name }}</p>
    </div>
</div>

{{-- Modal konfirmasi simpan (cozy) --}}
<div id="confirmModal" class="confirm-modal">
    <div class="confirm-box">
        <div class="confirm-emoji">🌿</div>
        <h3>Simpan perubahan?</h3>
        <p>Data profilmu akan diperbarui. Yakin sudah benar?</p>
        <div class="confirm-btns">
            <button type="button" onclick="closeConfirm()" class="btn-cancel">Batal</button>
            <button type="button" onclick="submitProfile()" class="btn-ok">Ya, Simpan</button>
        </div>
    </div>
</div>

<style>
.profile-card {
    max-width: 520px;
    margin: 0 auto;
    background: white;
    border-radius: 24px;
    padding: 36px 32px;
    box-shadow: 0 12px 40px rgba(90, 55, 30, 0.08);
}
.avatar-section { text-align: center; margin-bottom: 8px; }
.avatar-wrap {
    width: 110px; height: 110px;
    margin: 0 auto 10px;
    position: relative;
    cursor: pointer;
    border-radius: 50%;
}
.avatar-wrap img, .avatar-initial {
    width: 110px; height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f0e6d8;
}
.avatar-initial {
    background: #9c5638;
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; font-weight: 700;
}
.avatar-cam {
    position: absolute; bottom: 2px; right: 2px;
    width: 34px; height: 34px;
    background: #9c5638; color: white;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; cursor: pointer;
    border: 2px solid white;
}
.hapus-foto {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; color: #c0392b; cursor: pointer; margin-bottom: 6px;
}
.avatar-hint { font-size: 12px; color: #999; margin-top: 4px; }
.member-since {
    text-align: center;
    font-size: 13px; color: #8b7355;
    margin-bottom: 28px;
    padding: 8px 14px;
    background: #f8f1e9;
    border-radius: 20px;
    display: inline-block;
    width: 100%;
    box-sizing: border-box;
}
.form-group { margin-bottom: 18px; }
.form-group label {
    display: block; font-size: 13px; font-weight: 600;
    color: #3f2a20; margin-bottom: 7px;
}
.form-group input, .form-group textarea {
    width: 100%; padding: 13px 16px;
    border: 1.5px solid #e8ddd0; border-radius: 12px;
    font-size: 14.5px; background: #fffaf5;
    font-family: inherit; box-sizing: border-box;
}
.form-group input:focus, .form-group textarea:focus {
    outline: none; border-color: #9c5638;
}
.profile-actions {
    display: flex; gap: 12px; margin-top: 28px;
}

/* Photo modal */
.photo-modal {
    display: none; position: fixed; inset: 0;
    background: rgba(40, 25, 15, 0.75);
    z-index: 2000; align-items: center; justify-content: center;
    backdrop-filter: blur(4px);
}
.photo-modal.open { display: flex; }
.photo-modal-inner {
    position: relative; text-align: center;
    max-width: 90vw;
}
.photo-modal-inner img {
    max-width: 360px; max-height: 70vh;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.photo-modal-initial {
    width: 200px; height: 200px; border-radius: 50%;
    background: #9c5638; color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 56px; font-weight: 700; margin: 0 auto;
}
.photo-modal-inner p {
    color: white; margin-top: 16px; font-size: 16px; font-weight: 500;
}
.photo-close {
    position: absolute; top: -12px; right: -12px;
    width: 36px; height: 36px; border-radius: 50%;
    border: none; background: white; color: #3f2a20;
    font-size: 16px; cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Confirm modal cozy */
.confirm-modal {
    display: none; position: fixed; inset: 0;
    background: rgba(40, 25, 15, 0.5);
    z-index: 2001; align-items: center; justify-content: center;
}
.confirm-modal.open { display: flex; }
.confirm-box {
    background: white; border-radius: 24px;
    padding: 36px 32px; max-width: 340px; width: 90%;
    text-align: center;
    box-shadow: 0 20px 50px rgba(90, 55, 30, 0.2);
    animation: popIn 0.3s ease;
}
@keyframes popIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.confirm-emoji { font-size: 40px; margin-bottom: 12px; }
.confirm-box h3 {
    font-size: 1.2rem; color: #3f2a20; margin-bottom: 8px;
}
.confirm-box p {
    font-size: 14px; color: #6b5244; margin-bottom: 24px; line-height: 1.5;
}
.confirm-btns { display: flex; gap: 10px; }
.btn-cancel {
    flex: 1; padding: 12px; border-radius: 12px;
    border: 1.5px solid #e8ddd0; background: white;
    color: #5c4033; font-weight: 600; cursor: pointer; font-size: 14px;
}
.btn-ok {
    flex: 1; padding: 12px; border-radius: 12px;
    border: none; background: #9c5638; color: white;
    font-weight: 600; cursor: pointer; font-size: 14px;
}
.btn-ok:hover { background: #7d432c; }
</style>

<script>
function openPhotoModal() {
    document.getElementById('photoModal').classList.add('open');
}
function closePhotoModal() {
    document.getElementById('photoModal').classList.remove('open');
}
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrap = document.getElementById('avatarPreview');
            wrap.innerHTML = `
                <img src="${e.target.result}" alt="Preview" id="avatarImg" style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:3px solid #f0e6d8;">
                <label class="avatar-cam" onclick="event.stopPropagation(); document.getElementById('avatarInput').click();">📷</label>
            `;
            const modalImg = document.getElementById('modalPhoto');
            if (modalImg) modalImg.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function confirmSave() {
    document.getElementById('confirmModal').classList.add('open');
}
function closeConfirm() {
    document.getElementById('confirmModal').classList.remove('open');
}
function submitProfile() {
    document.getElementById('profileForm').submit();
}
// Tutup modal dengan Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePhotoModal();
        closeConfirm();
    }
});
</script>
@endsection