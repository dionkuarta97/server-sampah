<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class JwtToken
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $token = $request->header('access_token');
    $key = config('app.jwt_key');
    if (!$token) return gagal('Anda Tidak Dapat Akses', 401);

    try {
      $checkToken = JWT::decode($token, new Key($key, "HS256"));
    } catch (Exception $e) {
      return gagal($e->getMessage(), 401);
    }

    $issuedAt = time();

    if ($checkToken->expirationTime < $issuedAt) return gagal('sesi login anda kadaluarsa', 401);

    $user = [
      'id' => $checkToken->id,
      'nama' => $checkToken->nama,
      'email' => $checkToken->email,
      'role' => $checkToken->role,
      'expirationTime' => $checkToken->expirationTime
    ];


    $request->request->add(['user' => $user]);
    return $next($request);
  }
}
