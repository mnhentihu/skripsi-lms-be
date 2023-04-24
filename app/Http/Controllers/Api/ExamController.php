<?php

namespace App\Http\Controllers\Api;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\banksoal;
use Illuminate\Support\Facades\Validator;
use Tests\Unit\ExampleTest;

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
        try {
            $examsId = Exam::where('id_user', $request->id_user)
                ->where('level', $request->level)
                ->pluck('id_soal')->toArray();

            $idSoalsStr = implode('::', $examsId);
            $idSoalsArr = explode('::', $idSoalsStr);
            $idSoalsInt = array_map('intval', $idSoalsArr);

            $data = banksoal::whereIn('id', $idSoalsInt)->get();

            $soalsArr = [];
            foreach ($data as $soal) {
                $soalsArr[] = [
                    'id' => $soal->id,
                    'subject' => $soal->subject,
                    'soal' => $soal->soal,
                    'ansA' => $soal->ansA,
                    'ansB' => $soal->ansB,
                    'ansC' => $soal->ansC,
                    'ansD' => $soal->ansD,
                    'corAns' => $soal->corAns,
                    'level' => $soal->level,
                    'created_at' => $soal->created_at,
                    'updated_at' => $soal->updated_at,
                ];
            }

            $userHasExam = Exam::with('user')
                ->where('id_user', $request->id_user)
                ->where('level', $request->level)
                ->where('subject', $request->subject)
                ->whereIn('id_soal', $idSoalsInt)
                ->get();

            foreach ($userHasExam as $exam) {
                $soals = [];
                $ids = explode('::', $exam->id_soal);
                foreach ($ids as $id) {
                    foreach ($soalsArr as $soal) {
                        if ($soal['id'] == $id) {
                            $soals[] = $soal;
                            break;
                        }
                    }
                }
                $exam->id_soal = $soals;
            }
            // return $userHasExam;

            if (count($userHasExam) != 0) {
                return $userHasExam;
            } else {
                $exams = banksoal::where('subject', $request->subject)
                    ->where('level', $request->level)
                    ->inRandomOrder()
                    ->take(10)
                    ->get();

                $idSoals = $exams->pluck('id')->toArray();
                $idSoalsStr = implode('::', $idSoals);


                Exam::create([
                    'id_soal' => $idSoalsStr,
                    'id_user' => $request->id_user,
                    'level' => $request->level,
                    'subject' => $request->subject,
                    'kesempatan' => '1'
                ]);

                $idSoalsArr = explode('::', $idSoalsStr);
                $idSoalsInt = array_map('intval', $idSoalsArr);

                $data = banksoal::whereIn('id', $idSoalsInt)->get();

                $soalsArr = [];
                foreach ($data as $soal) {
                    $soalsArr[] = [
                        'id' => $soal->id,
                        'subject' => $soal->subject,
                        'soal' => $soal->soal,
                        'ansA' => $soal->ansA,
                        'ansB' => $soal->ansB,
                        'ansC' => $soal->ansC,
                        'ansD' => $soal->ansD,
                        'corAns' => $soal->corAns,
                        'level' => $soal->level,
                        'created_at' => $soal->created_at,
                        'updated_at' => $soal->updated_at,
                    ];
                }

                $examsData = Exam::with('user')
                    ->where('id_user', $request->id_user)
                    ->where('level', $request->level)
                    ->whereIn('id_soal', $idSoalsInt)
                    ->get();

                foreach ($examsData as $exam) {
                    $soals = [];
                    $ids = explode('::', $exam->id_soal);
                    foreach ($ids as $id) {
                        foreach ($soalsArr as $soal) {
                            if ($soal['id'] == $id) {
                                $soals[] = $soal;
                                break;
                            }
                        }
                    }
                    $exam->id_soal = $soals;
                }

                return new ExamResource(true, 'List Data Exam', $examsData);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function show($id_user, $level, $subject)
    {
        try {
            $examsId = Exam::where('id_user', $id_user)
                ->where('level', $level)
                ->where('subject', $subject)
                ->pluck('id_soal')->toArray();

            $idSoalsStr = implode('::', $examsId);
            $idSoalsArr = explode('::', $idSoalsStr);
            $idSoalsInt = array_map('intval', $idSoalsArr);

            // $data = banksoal::whereIn('id', $idSoalsInt)->get();
            $data = banksoal::whereIn('id', $idSoalsInt)
                ->orderByRaw('FIELD(id, ' . implode(',', $idSoalsInt) . ')')
                ->get();

            $soalsArr = [];
            foreach ($data as $soal) {
                $soalsArr[] = [
                    'id' => $soal->id,
                    'subject' => $soal->subject,
                    'soal' => $soal->soal,
                    'ansA' => $soal->ansA,
                    'ansB' => $soal->ansB,
                    'ansC' => $soal->ansC,
                    'ansD' => $soal->ansD,
                    'corAns' => $soal->corAns,
                    'level' => $soal->level,
                    'created_at' => $soal->created_at,
                    'updated_at' => $soal->updated_at,
                ];
            }

            $userHasExam = Exam::with('user')
                ->where('id_user', $id_user)
                ->where('level', $level)
                ->where('subject', $subject)
                ->whereIn('id_soal', $idSoalsInt)
                ->get();

            foreach ($userHasExam as $exam) {
                $soals = [];
                $ids = explode('::', $exam->id_soal);
                foreach ($ids as $id) {
                    foreach ($soalsArr as $soal) {
                        if ($soal['id'] == $id) {
                            $soals[] = $soal;
                            break;
                        }
                    }
                }
                $exam->id_soal = $soals;
            }

            return new ExamResource(true, 'List Data Exam', $userHasExam);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request)
    {
        // try {
        $examsId = Exam::where('id', $request->id)
            ->where('id_user', $request->id_user)
            ->where('level', $request->level)
            ->where('subject', $request->subject)
            ->pluck('id_soal')->toArray();

        $idSoalsStr = implode('::', $examsId);
        $idSoalsArr = explode('::', $idSoalsStr);
        $idSoalsInt = array_map('intval', $idSoalsArr);

        // $data = banksoal::whereIn('id', $idSoalsInt)->get();
        $data = banksoal::whereIn('id', $idSoalsInt)
            ->orderByRaw('FIELD(id, ' . implode(',', $idSoalsInt) . ')')
            ->get();

        $soalsArr = [];
        foreach ($data as $soal) {
            $soalsArr[] = [
                'corAns' => $soal->corAns,
            ];
        }

        // $jawabanArr = json_decode(json_encode($request->jawaban), true);

        $matchedCount = 0;
        $dataChance = Exam::where('id_user', $request->id_user)
            ->where('level', $request->level)
            ->where('subject', $request->subject)
            ->value('kesempatan');

        $dataLulus = Exam::where('id_user', $request->id_user)
            ->where('level', $request->level)
            ->where('subject', $request->subject)
            ->value('status_kelulusan');

        $kelulusan = '';

        foreach ($request->jawaban as $index => $jawaban) {
            // Calculate the score for this item
            if (isset($soalsArr[$index]) && $jawaban == $soalsArr[$index]['corAns']) {
                $matchedCount++;
            }

            $score = $matchedCount * 10;

            // Calculate the kesempatan value
            if ($score >= 80) {
                $kelulusan = 'lulus';
            } else {
                $kelulusan = 'belum';
            }
        }

        $kesempatan = 0;
        if ($dataChance == null) {
            $kesempatan = 1;
        } elseif ($dataChance == 1) {
            $kesempatan = 2;
        } elseif ($dataChance == 2) {
            $kesempatan = 3;
        } elseif ($dataChance == 3) {
            $kesempatan = 3;
            $kelulusan = 'lulus';
        } else {
            $kesempatan = 3;
        }

        // Update the Exam model for this item
        Exam::where('id_user', $request->id_user)
            ->where('level', $request->level)
            ->where('subject', $request->subject)
            ->update([
                'jawaban' => $request->jawaban,
                'score' => $score,
                'kesempatan' => $kesempatan,
                'status_kelulusan' => $kelulusan
            ]);
        // return new ExamResource(true, 'List Data Exam', $dataChance);
        return ('Data Jawaban Berhasil Di Update!');
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'error' => $e->getMessage(),
        //     ]);
        // }

    }
    public function showScore($id_user)
    {
        // $scores = Exam::where('id_user', $id_user)
        //         ->orderBy('level', 'asc')
        //         ->get(['subject', 'score'])
        //         ->groupBy('subject')
        //         ->map(function ($subject_scores) {
        //             return $subject_scores->pluck('score')->toArray();
        //         });


        // return new ExamResource(true, 'List Data Score', $scores);
        $scores = Exam::where('id_user', $id_user)
            ->orderBy('level', 'asc')
            ->get(['subject', 'score', 'level']);

        $subject_scores = [];

        foreach ($scores as $score) {
            $subject_scores[$score->subject][$score->level] = $score['score'];
        }

        $result = [];

        foreach ($subject_scores as $subject => $scores) {
            $result[] = [
                'subject' => $subject,
                'scores' => $scores,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'List Data Score',
            'data' => $result,
        ]);
    }
}
