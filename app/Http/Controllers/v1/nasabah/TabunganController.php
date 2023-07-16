<?php

namespace App\Http\Controllers\v1\nasabah;

use App\Http\Controllers\Controller;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TabunganController extends Controller
{
    //

    public function createTabungan(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'id_jenis_tabungan' => 'required|numeric',
            ], [
                'id_jenis_tabungan.required' => 'Jenis tabungan tidak boleh kosong',
                'id_jenis_tabungan.numeric' => 'id jenis tabungan berupa angka'
            ]);
            if ($validator->fails()) return gagal($validator->errors(), 400);

            $user = $request->get('user');
            $cekTabungan = Tabungan::where('id_nasabah', $user['id'])->first();
            if ($cekTabungan) return gagal('tabungan anda sudah ada', 400);
            $num = str_pad($user['id'], 5, "0", STR_PAD_LEFT);
            $ranStr = Str::random(2);
            $id_jenis_tabungan = $request->id_jenis_tabungan;
            if ($id_jenis_tabungan < 10) $id_jenis_tabungan = "0" . $id_jenis_tabungan;
            $no_tabungan = $id_jenis_tabungan . Str::upper($ranStr) . $num;

            $tabungan = Tabungan::create([
                'no_tabungan' => $no_tabungan,
                'id_jenis_tabungan' => $request->id_jenis_tabungan,
                'id_nasabah' => $user['id'],
                'saldo' => 0
            ]);

            return sukses($tabungan, 201);
        } catch (\Exception $e) {
            return gagal($e->getMessage(), 500);
        }
    }
}
