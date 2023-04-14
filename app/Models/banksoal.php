<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banksoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'soal',
        'ansA',
        'ansB',
        'ansC',
        'ansD',
        'corAns',
        'level',
    ];

    protected $table = "banksoal";

    // public function exams() {
    //     return $this->hasMany(Exam::class, 'id_soal');
    // }
}
