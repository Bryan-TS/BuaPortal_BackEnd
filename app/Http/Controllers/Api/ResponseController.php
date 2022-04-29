<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Response;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr;

class ResponseController extends Controller
{

    public function index()
    {
        $status = "Success";
        $code = 200;

        $data = Response::all(); 

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

        try{

            $response = new Response();
            $response->description = $request->description;
            $response->user_id = $request->userId;
            $response->question_id = $request->questionId;

            $response->save();            
            $data = array("response_id" => $response->id);
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

    public function show($id)
    {
        $status = "Success";
        $code = 200;

        $response = Response::find($id);

        if(empty($response)){
            $code = 204;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $response
        );

        return $response;
    }

    public function update(Request $request, $id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        try{    

            $response = Response::findOrFail($id);
            $response->description = $request->description;

            $response->save();

            $data = array("question_id" => $response->id);

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

    public function destroy($id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        try{
            $data = Response::destroy($id);
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

    public function responsesByQuestion($id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        $data = Response::where('question_id', '=', $id)->get();

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
}
