<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'alamat',
        'type',
        'waktu_jam',
        'total_harga',
        'jam_mulai',
        'supir',
        'jam_selesai',
        'tempat_tujuan',
        'riwayat_perjalanan',
        'status',
    ];
}
