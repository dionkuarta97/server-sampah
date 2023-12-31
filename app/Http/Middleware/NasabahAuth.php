<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NasabahAuth
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
    $user = $request->get('user');
    if ($user['role'] != 1) return gagal('Anda Tidak Dapat Akses', 401);
    return $next($request);
  }
}
