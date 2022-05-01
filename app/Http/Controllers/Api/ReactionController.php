<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reaction;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Isset_;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ReactionController extends Controller
{

    public function index()
    {
        $status = "Success";
        $code = 200;

        $data = Reaction::all(); 

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

    public function likesByResponse($id){
        $status = "Success";
        $code = 200;
        $data = array();

        $data = Reaction::where('response_id', '=', $id)
                        ->where('liked', '=', 1)  
                        ->get();

        $data = $data->count();

        if($data == 0){
            $code = 204;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $data
        );

        return $response;    
    }

    public function unlikesByResponse($id){
        $status = "Success";
        $code = 200;
        $data = array();

        $data = Reaction::where('response_id', '=', $id)
                        ->where('unliked', '=', 1)  
                        ->get();

        $data = $data->count();

        if($data == 0){
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
        
        
        //First check if exist reaction of user
        // $reactionRequest = ReactionController::reactionsByUserAndResponse($request->user_id,$request->response_id);


        // if(!$reactionRequest['data']->isEmpty()){
        //     $response = "No esta vacio";
        // }else{
        //     $response = "Esta vacio";
        // }

        $data = Reaction::where('user_id', '=', $request->user_id)
                ->where('response_id', '=', $request->response_id)  
                ->first();

        if(is_null($data)){
            try{

                $reaction = new Reaction();
                $reaction->liked = $request->liked;
                $reaction->unliked = $request->unliked;
                $reaction->user_id = $request->user_id;
                $reaction->response_id = $request->response_id;

                $reaction->save();            
                // $data = array("reaction" => $reaction);
                $data = $reaction;
            }catch(Exception $e){
                $status = "Error";
                $code = 400;
            }

            $response = array(
                'status' => $status,
                'code' => $code,
                'data' => $data
            );
        }else{
            try{    

                $reaction = Reaction::findOrFail($data->id);
                $reaction->liked = $request->liked;
                $reaction->unliked = $request->unliked;
    
                $reaction->save();
    
                // $data = array("reaction" => $reaction);
                $data = $reaction;
    
            }catch(Exception $e){
                $status = "Error";
                $code = 400;
            }
    
            $response = array(
                'status' => $status,
                'code' => $code,
                'data' => $data
            );
        }    
        return $response; 
    }


    public function show($id)
    {
        $status = "Success";
        $code = 200;

        $reaction = Reaction::find($id);

        if(empty($reaction)){
            $code = 204;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $reaction
        );

        return $response;
    }


    public function update(Request $request, $id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        try{    

            $reaction = Reaction::findOrFail($id);
            $reaction->liked = $request->liked;
            $reaction->unliked = $request->unliked;

            $reaction->save();

            $data = array("reaction_id" => $reaction->id);

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
            $data = Reaction::destroy($id);
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

    public function reactionsByResponse($id){
        $status = "Success";
        $code = 200;
        $data = array();

        $data = Reaction::where('response_id', '=', $id)->first();

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

    public function reactionsByUserAndResponse($user_id,$response_id){
        $status = "Success";
        $code = 200;
        $data = array();

        $data = Reaction::where('user_id', '=', $user_id)
                        ->where('response_id', '=', $response_id)  
                        ->first();

        if(is_null($data)){
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
