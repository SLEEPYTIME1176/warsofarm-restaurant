<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'no_hp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:500',
        'password' => 'nullable|min:6|confirmed',
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
    ];

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    if ($request->has('hapus_foto') && $user->avatar) {
        \Storage::disk('public')->delete($user->avatar);
        $data['avatar'] = null;
    }

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            \Storage::disk('public')->delete($user->avatar);
        }
        $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user->update($data);

    return back()->with('success', 'Profil berhasil diperbarui');
}
}