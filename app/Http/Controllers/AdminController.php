<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Login;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        if (session('data_login')) {
            return view('admin.index');
        }
        return redirect()->back();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function login()
    {
        if (session('data_login')) {
            return redirect('/admin');
        }
        return view('admin.admin-login');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
    public function postlogin(Request $request)
    {
        $data_login = Login::where('username', $request->username)->firstOrFail();
        $cek_password = Hash::check($request->password, $data_login->password);
        $cek_level = $data_login->level;
        if ($data_login) {
            if ($cek_password) {
                switch ($cek_level) {
                    case "admin":
                        $users = session(['data_login' => $data_login]);
                        return redirect('/admin');
                        break;
                    case "user":
                        $users = session(['data_login' => $data_login]);
                        return redirect('/admin');
                        break;
                }
            }
        }
        return redirect('/admin/login')->with('status_fail', 'Login gagal, username atau password salah')->withInput();
    }
    public function register()
    {
        return view('admin.register');
    }

    public function postregister(Request $request)
    {
        $login_data = new Login;

        $validatedLogin = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $hashPassword = Hash::make($request->password, [
            'rounds' => 12,
        ]);

        $token = Str::random(16);

        $level = "admin";

        $login_data = Login::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => $hashPassword,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'token' => $token,
            'level' => $level,
            'created_at' => now(),
            'updated-at' => now()
        ]);

        $login_data->save();

        return redirect('/admin/login')->with('berhasil_register', 'Berhasil melakukan registrasi');
    }
}
