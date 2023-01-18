<?php

namespace App\Http\Controllers\Api;

use App\Models\materi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\materiResource;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class materiController extends Controller
{
    /**
     * indexa
     *
     * @return void
     */
    public function index()
    {
        //get posts
        $posts = materi::all();

        //return collection of posts as a resource
        return new materiResource(true, 'List Data materi', $posts);
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
            'namaMateri'  => 'required',
            'keterangan'     => 'required',
            'idVideo'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $materi = materi::create([
            'namaMateri'  => $request->namaMateri,
            'keterangan'     => $request->keterangan,
            'idVideo'     => $request->idVideo,
        ]);

        //return response
        return new materiResource(true, 'Data materi Berhasil Ditambahkan!', $materi);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(materi $materi)
    {
        //return single post as a resource
        return new materiResource(true, 'Data materi Ditemukan!', $materi);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, materi $materi)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'namaMateri'  => 'required',
            'keterangan'     => 'required',
            'idVideo'     => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        $materi->update([
            'namaMateri'  => $request->namaMateri,
            'keterangan'     => $request->keterangan,
            'idVideo'     => $request->idVideo,
        ]);


        //return response
        return new materiResource(true, 'Data Materi Berhasil Diubah!', $materi);
    }

    public function destroy(materi $materi)
    {

        //delete post
        $materi->delete();

        //return response
        return new materiResource(true, 'Data Materi Berhasil Dihapus!', null);
    }
}
