<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\banksoal;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function index()
    {
        //get posts
        $posts = Exam::latest()->paginate(5);

        //return collection of posts as a resource
        return new ExamResource(true, 'List Data Exam', $posts);
    }

    public function store(Request $request)
    {
        $userHasExam = Exam::with('user')->where('id_user', $request->id_user)
            ->where('exams.level', $request->level)
            ->join('banksoal', 'exams.id_soal', '=', 'banksoal.id')
            ->where('banksoal.subject', $request->subject)->get();

        if (count($userHasExam) != 0) {
            return $userHasExam;
        } else {
            $exams = banksoal::where('subject', $request->subject)->where('level', $request->level)
                ->inRandomOrder()->take(10)->get();

            foreach ($exams as $exam) {
                Exam::create([
                    'id_soal' => $exam->id,
                    'id_user' => $request->id_user,
                    'level' => $exam->level,
                    'status_exam' => 'belum'
                ]);
            }

            $exams = Exam::with('user')->where('id_user', $request->id_user)
                ->where('exams.level', $request->level)
                ->join('banksoal', 'exams.id_soal', '=', 'banksoal.id')
                ->where('banksoal.subject', $request->subject)->get();

            return $exams;
        }
    }
}
