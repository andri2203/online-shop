<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\MailService;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function verify()
    {
        return view('verify');
    }

    public function register()
    {
        return view('register');
    }

    public function login_proces(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        try {

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                if ($user->email_verified_at == null) {
                    MailService::mailCodeVerifySend($user->email);

                    return redirect('/verify');
                }

                if ($user->role->value === 'customer') {
                    return redirect('/');
                } elseif ($user->role->value === 'store') {
                    return redirect('/toko');
                } else {
                    Auth::logout();
                    return back()->withInput()->with('danger', 'Peran pengguna tidak valid. ' . $user->role);
                }
            }

            return back()->withInput()->with('danger', 'Username atau password salah.');
        } catch (\Throwable $th) {
            Auth::logout();
            return back()->withInput()->with('danger', 'Terjadi Kesalahan : ' . $th->getMessage());
        }
    }

    public function verify_proces(Request $request)
    {
        try {
            //code...
            $request->validate(['verificationCode' => 'required|digits:6']);

            $user = User::find(Auth::id()); // Karena user sudah login

            if (!$user) {
                return redirect('/login')->with('danger', 'Sesi Anda telah berakhir. Silakan login kembali.');
            }

            $sessionKey = "verification_code_{$user->email}";
            $expectedCode = session($sessionKey);

            if (!$expectedCode) {
                MailService::mailCodeVerifySend($user->email);

                return redirect('/verify')->with('danger', 'Kode verifikasi sudah kadaluarsa. Mengirim Ulang Kode Verifikasi');
            }

            if ($expectedCode['code'] != $request->verificationCode) {
                return back()->with('danger', 'Kode verifikasi salah. ' . $expectedCode['code']);
            }

            // ✅ Simpan manual
            $user->email_verified_at = now();
            $user->save();

            // Hapus kode verifikasi dari session
            session()->forget($sessionKey);

            if ($user->role->value === 'customer') {
                return redirect('/');
            } elseif ($user->role->value === 'store') {
                return redirect('/toko');
            } else {
                Auth::logout();
                return back()->withInput()->with('danger', 'Peran pengguna tidak valid. ');
            }
        } catch (\Throwable $th) {
            return back()->withInput()->with('danger', 'Terjadi Kesalahan : ' . $th->getMessage());
        }
    }

    public function register_proces(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string',
            'role' => 'required|in:customer,store',
        ]);

        try {
            User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            return redirect('/toko')->with('danger', 'Peran pengguna tidak valid.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('danger', 'Terjadi Kesalahan : ' . $th->getMessage());
        }
    }
}
