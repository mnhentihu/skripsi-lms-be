<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materi extends Model
{
    use HasFactory;
    protected $fillable = [
        'namaMateri',
        'keterangan',
        'idVideo',
    ];

    protected $table = "materi";
}
