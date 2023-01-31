<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_soal',
        'id_user',
        'level',
        'jawaban',
        'status_exam',
        'status_kelulusan',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function banksoal() {
        return $this->belongsTo(User::class, 'id_soal');
    }

}
