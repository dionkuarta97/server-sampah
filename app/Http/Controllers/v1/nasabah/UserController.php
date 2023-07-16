<?php

namespace App\Http\Controllers\v1\nasabah;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'nama' => 'required',
                'password' => 'required|min:8',
                'role' => 'required|numeric'
            ], [
                'email.required' => 'email tidak boleh kosong',
                'email.email' => 'bukan format email',
                'email.unique' => 'email sudah pernah digunakan',
                'nama.required' => 'nama tidak boleh kosong',
                'password.required' => 'password tidak boleh kosong',
                'password.min' => 'password minimal 8 karakter',
                'role.required' => 'role tidak boleh kosong',
                'role.numeric' => 'role harus berupa angka'

            ]);
            if ($validation->fails()) return gagal($validation->errors(), 400);


            $user = Users::create([
                'email' => $request->email,
                'password' => Crypt::encryptString($request->password),
                'nama' => $request->nama,
                'role' => $request->role,
                'active' => true
            ]);
            return sukses($user, 201);
        } catch (Exception $e) {
            return gagal($e->getMessage(), 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'email|required',
                'password' => 'required'
            ], [
                'email.required' => 'email tidak boleh kosong',
                'email.email' => 'tidak format email',
                'password.required' => 'password tidak boleh kosong',
            ]);

            if ($validation->fails()) return gagal($validation->errors(), 400);

            $user = Users::where([['email', '=', $request->email]])->first();

            if (!$user) return gagal('email/password salah', 401);

            if ($request->password !== Crypt::decryptString($user['password'])) return gagal('email/password salah', 401);
            if (!$user->active) return gagal('akun anda belum teriverifikasi, silahkan check email anda');

            $issuedAt = time();


            $payload = [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
                'role' => $user['role'],
                'expirationTime' => $issuedAt + 60 * 60 * 24
            ];
            $key = config('app.jwt_key');
            $access_token = JWT::encode($payload, $key, 'HS256');

            return sukses(['access_token' => $access_token, 'user' => $user], 200);
        } catch (Exception $e) {
            return gagal($e->getMessage(), 500);
        }
    }
}
