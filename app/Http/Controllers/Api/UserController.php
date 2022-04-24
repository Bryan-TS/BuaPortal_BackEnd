<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request){
        $user =     User::select('id','email','name','lastName','description')
                    ->where('email',$request->email)
                    ->where('password',$request->password)
                    ->first();

        if($user !== null){
            // $token = hash('sha256', $user->email);
            return $user;
        }else{
            return $response['status'] = "401";
        }

        
    }


    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->description = $request->description;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();
    }


    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->lastName = $request->lastName;
        $user->description = $request->description;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();

        return $user;
    }

    public function destroy($id)
    {
        $user = User::destroy($id);
        return $user;
    }
}
