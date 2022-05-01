<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request){
        $status = "Success";
        $code = 200;

        $data = User::select('id','email','name','lastName','description')
                    ->where('email',$request->email)
                    ->where('password',$request->password)
                    ->first();
                
        if(empty($data)){
            $code = 204;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $data
        );

        return $response;    
    }


    public function index()
    {
        $status = "Success";
        $code = 200;

        $data = User::all(); 

        if(empty($data)){
            $code = 204;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $data
        );

        return $response;
    }

    public function store(Request $request)
    {
        $status = "Success";
        $code = 200;
        $data = array();
        
        $data = User::where('email','=',$request->email)->first();

        if(is_null($data)){
            try{
                $user = new User();
                $user->name = $request->name;
                $user->lastName = $request->lastName;
                $user->description = $request->description;
                $user->email = $request->email;
                $user->password = $request->password;
    
                $user->save();
                $data = array("user_id" => $user->id);
            }catch(Exception $e){            
                $status = "Error";
                $code = 400;
            }
    
           
        }else{
            $code = 208;
            $data = array();
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $data
        );
        
        return $response;  
    }


    public function show($id)
    {
        $status = "Success";
        $code = 200;

        $data = User::find($id);

        if(empty($question)){
            $code = 204;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $data
        );

        return $response;
    }

    public function update(Request $request, $id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        try{    

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->lastName = $request->lastName;
            $user->description = $request->description;
            $user->email = $request->email;

            $user->save();

            $data = array("question_id" => $user->id);

        }catch(Exception $e){
            $status = "Error";
            $code = 400;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $data
        );

        return $response;
    }


    //If response in data is 0 means that didn't fail in request but didn't delete the id requested but if was 1 was deleted    
    public function destroy($id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        try{
            $data = User::destroy($id);
        }catch(Exception $e){
            $status = "Error";
            $code = 400;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $data
        );
        
        return $response;
    }
}
