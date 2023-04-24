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
        'subject',
        'jawaban',
        'score',
        'kesempatan',
        'status_kelulusan',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    protected $casts = [
        'jawaban' => 'array',
    ];

    // public function banksoal() {
    //     return $this->belongsTo(User::class, 'id_soal');
    // }

}
