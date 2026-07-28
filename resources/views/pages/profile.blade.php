@extends('layouts.app')

@section('content')
<div class="container" style="padding: 60px 24px 80px;">
    <div class="section-header">
        <h2>Edit Profil</h2>
        <p>Kelola informasi dan foto profil Anda</p>
    </div>

    @if(session('success'))
        <div style="max-width:560px; margin:0 auto 30px; background:#d4edda; color:#155724; padding:16px 20px; border-radius:14px; text-align:center;">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-card" style="max-width:560px;">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Avatar Preview --}}
            <div style="text-align:center; margin-bottom:32px;">
                <div style="position:relative; display:inline-block;">
                    <img id="avatarPreview"
                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=9c5638&color=fff&size=150' }}"
                         alt="Avatar"
                         style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:4px solid #f0e6d8; box-shadow:0 8px 24px rgba(90,55,30,0.12);">
                    
                    <label for="avatarInput" style="position:absolute; bottom:0; right:0; width:36px; height:36px; background:var(--primary); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 4px 12px rgba(156,86,56,0.3); font-size:16px;">
                        📷
                    </label>
                    <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                </div>

                @if($user->avatar)
                    <div style="margin-top:12px;">
                        <label style="display:inline-flex; align-items:center; gap:6px; cursor:pointer; font-size:13px; color:#c0392b;">
                            <input type="checkbox" name="hapus_avatar" value="1">
                            Hapus foto profil
                        </label>
                    </div>
                @endif
                <p style="font-size:12px; color:#888; margin-top:10px;">Klik ikon kamera untuk ganti foto (JPG/PNG, max 2MB)</p>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Password Baru (opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                @error('password') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:16px; font-size:16px;">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection