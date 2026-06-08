<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $emailChanged = $request->email !== $user->email;
        $rules = [
            'name'       => ['required','string','max:255'],
            'email'      => ['required','email','unique:users,email,'.$user->id],
            'no_wa'      => ['nullable','string','max:20'],
            'foto_profil'=> ['nullable','image','max:2048'],
        ];
        if ($user->isSiswa()) $rules['nis'] = ['required','string','max:20','unique:users,nis,'.$user->id];

        $request->validate($rules);

        $data = ['name'=>$request->name,'email'=>$request->email,'no_wa'=>$request->no_wa];
        if ($user->isSiswa()) $data['nis'] = $request->nis;

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) Storage::disk('public')->delete($user->foto_profil);
            $data['foto_profil'] = $request->file('foto_profil')->store('profil','public');
        }
        if ($request->has('hapus_foto') && $user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
            $data['foto_profil'] = null;
        }

        $user->fill($data);
        if ($emailChanged) {
            $user->email_verified_at = null;
        }
        $user->save();
        ActivityLog::catat('edit_profil','Mengubah data profil','User',$user->id);

        return redirect()->route('profile.edit')->with('success','Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required','confirmed', Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password'=>'Password lama salah!']);
        }

        Auth::user()->update(['password'=>Hash::make($request->password)]);
        ActivityLog::catat('ganti_password','Mengubah password');

        return back()->with('success','Password berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        if (!$user->isSiswa()) return back();

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();
        if ($user->foto_profil) Storage::disk('public')->delete($user->foto_profil);
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
