<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory;
    protected $fillable = ['no_tabungan', 'id_jenis_tabungan', 'id_nasabah', 'saldo'];
}
