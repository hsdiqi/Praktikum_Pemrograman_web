<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\allResource;
use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    public function index(){
        $post = pengguna::latest()->paginate(5);

        return new allResource(true, 'List data Users: ', $post);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'telephon' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = pengguna::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'address' => $request->address,
            'telephon' => $request->telephon,
        ]);

        return new allResource(true, "User baru ditambahkan", $post);
    }

    public function show($id) {
        $users = pengguna::find($id);

        return new allResource(true, 'List data user', $users);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'telephon' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $users = pengguna::find($id);

        $users->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'address' => $request->address,
            'telephone' => $request->telephone
        ]);

        return new allResource(true, 'user diipdate', $users);
    }

    public function destroy($id){
        $user = pengguna::find($id);
        
        $user->delete();

        return new allResource(true, 'user dihapus', null);
    }

}
