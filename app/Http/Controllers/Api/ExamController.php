<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\banksoal;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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
        // $userHasExam = User::whereHas('exams', function (Builder $query) use ($request) {
        //     $query -> where('subject', $request -> subject) -> where('level', $request->level);
        // })->get();

        // $userHasExam = User::whereHas('exams', function (Builder $query) use ($request) {
        //     $query -> where('id_soal', $request -> id_soal);
        // })->get();
        $userHasExam = Exam::with(['banksoal', 'user'])->where('id_user', Auth::id())
                        ->where('id_soal', $request->id_soal)->get();

        return $userHasExam;
        // if (! $userHasExam) {
        //     $exams = banksoal::where('subject', $request->subject)->where('level', $request->level)->inRandomOrder()->get(10);
            
        //     foreach($exams as $exam){
        //         Exam::create([
        //             'id_soal' => $exam->id,
        //             'id_user' => Auth::id(),
        //             'level' => $exam->level,
        //             'status_exam' => 'belum'
        //         ]);
        //     }
        // }

        // $exam = Exam::with('banksoal')->where('id_user', Auth::id())->where('subject', $request->subject)
        //         ->where('level', $request->level)->get();

        // return new ExamResource(true, 'Data Exam Berhasil Ditambahkan!', $exam);
    }
}
