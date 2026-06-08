<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        // Daftar kelas yang tersedia
        $kelasList = [
            'X TJKT 1','X TJKT 2','X SIJA 1','X SIJA 2',
            'XI TJKT 1','XI TJKT 2','XI SIJA 1','XI SIJA 2',
            'XII TJKT 1','XII TJKT 2','XII SIJA 1','XII SIJA 2',
        ];
        return view('auth.register', compact('kelasList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $kelasList = [
            'X TJKT 1','X TJKT 2','X SIJA 1','X SIJA 2',
            'XI TJKT 1','XI TJKT 2','XI SIJA 1','XI SIJA 2',
            'XII TJKT 1','XII TJKT 2','XII SIJA 1','XII SIJA 2',
        ];

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nis'      => ['required', 'string', 'max:20', 'unique:users,nis'],
            'kelas'    => ['required', 'in:' . implode(',', $kelasList)],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nis.required'   => 'NIS wajib diisi.',
            'nis.unique'     => 'NIS sudah terdaftar.',
            'kelas.required' => 'Kelas wajib dipilih.',
            'kelas.in'       => 'Kelas tidak valid.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'nis'      => $request->nis,
            'kelas'    => $request->kelas,
            'email'    => $request->email,
            'role'     => 'siswa',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
