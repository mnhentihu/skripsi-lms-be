<?php

namespace App\Http\Controllers\Api;

use App\Models\banksoal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\banksoalResource;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class banksoalController extends Controller
{
    /**
     * indexa
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = banksoal::all();

        //return collection of posts as a resource
        return new banksoalResource(true, 'List Data banksoal', $posts);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'subject'  => 'required',
            'soal'     => 'required',
            'ansA'     => 'required',
            'ansB'     => 'required',
            'ansC'     => 'required',
            'ansD'     => 'required',
            'corAns'   => 'required',
            'level'    => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $banksoal = banksoal::create([
            'subject'  => $request->subject,
            'soal'     => $request->soal,
            'ansA'     => $request->ansA,
            'ansB'     => $request->ansB,
            'ansC'     => $request->ansC,
            'ansD'     => $request->ansD,
            'corAns'   => $request->corAns,
            'level'    => $request->level,
        ]);

        //return response
        return new banksoalResource(true, 'Data banksoal Berhasil Ditambahkan!', $banksoal);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(banksoal $banksoal)
    {
        //return single post as a resource
        return new banksoalResource(true, 'Data banksoal Ditemukan!', $banksoal);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, banksoal $banksoal)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'subject'  => 'required',
            'soal'     => 'required',
            'ansA'     => 'required',
            'ansB'     => 'required',
            'ansC'     => 'required',
            'ansD'     => 'required',
            'corAns'   => 'required',
            'level'    => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $banksoal->update([
            'subject'  => $request->subject,
            'soal'     => $request->soal,
            'ansA'     => $request->ansA,
            'ansB'     => $request->ansB,
            'ansC'     => $request->ansC,
            'ansD'     => $request->ansD,
            'corAns'   => $request->corAns,
            'level'    => $request->level,
        ]);


        //return response
        return new banksoalResource(true, 'Data banksoal Berhasil Diubah!', $banksoal);
    }

    public function destroy(banksoal $banksoal)
    {

        //delete post
        $banksoal->delete();

        //return response
        return new banksoalResource(true, 'Data banksoal Berhasil Dihapus!', null);
    }
}
