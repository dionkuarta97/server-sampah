<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'email', 'password', 'role', 'active'];
    protected $hidden = ['password'];

    public function tabungan()
    {
        return $this->hasOne(Tabungan::class, 'id_nasabah', 'id');
    }
}
