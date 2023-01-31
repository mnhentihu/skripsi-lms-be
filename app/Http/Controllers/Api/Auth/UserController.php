<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // /
    //  * Handle the incoming request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'string', 'max:255'],
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/users', $image->hashName());
            $fileImage = $image->hashName();
        } else {
            $fileImage = null;
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'image'     => $fileImage,
        ]);

        $token = $user->createToken('myAppToken');

        return (new UserResource(true, 'Data User Berhasil Ditambahkan!', $user))->additional([
            'token' => $token->plainTextToken,
        ]);
    }

    // /
    //  * index
    //  *
    //  * @return void
    //  */
    public function index(User $users)
    {
        //get Users
        $users = User::all();

        //return collection of Users as a resource
        return new UserResource(true, 'List Data Users', $users);
    }

    public function show(User $user)
    {
        //return single User as a resource
        return new UserResource(true, 'Data User Ditemukan!', $user);
    }

    public function update(Request $request, User $user)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'min:8'],
            'role' => ['nullable', 'string', 'max:255'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {

            //upload image
            $image = $request->file('image');
            $image->storeAs('public/users', $image->hashName());

            //delete old image
            Storage::delete('public/users' . $user->image);

            //update post with new image
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'image'     => $image->hashName(),
            ]);
        } else {

            //update post without image
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
        }

        //return response
        return new UserResource(true, 'Data User Berhasil Diubah!', $user);
    }


    public function destroy(User $user)
    {
        //delete image
        Storage::delete('public/users' . $user->image);

        //delete User
        $user->delete();

        //return response
        return new UserResource(true, 'Data User Berhasil Dihapus!', null);
    }

    public function showImage(User $user)
    {
        return Storage::url('public/users/' . $user->image);
    }

    public function updateProfile(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255']
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);


        return new UserResource(true, 'Data Nama Berhasil Di Update!', $user);
    }

    public function updatePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['nullable', 'min:8'],
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);


        return new UserResource(true, 'Data Password Berhasil Di Update!', $user);
    }

    public function updateImage(Request $request, User $user)
    {
        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('public/users', $imageName);

        if ($user->image) {
            Storage::delete('public/users/'. $user->image);
        }

        $user->update([
            'image'     => $imageName,
        ]);

        return new UserResource(true, 'Data Image Berhasil Di Update!', $user);
    }
}
