<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr;

class QuestionController extends Controller
{
    public function index()
    {
        $status = "Success";
        $code = 200;

        $data = Question::all(); 

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

            $question = new Question();
            $question->category = $request->category;
            $question->title = $request->title;
            $question->description = $request->description;
            $question->user_id = $request->userId;

            $question->save();            
            $data = array("question_id" => $question->id);
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

        $question = Question::Select('questions.id','questions.category','questions.title','questions.description','questions.user_id','users.name','users.lastName')
                            ->join('users','users.id','=','questions.user_id')                        
                            ->find($id);

        if(empty($question)){
            $code = 204;
        }

        $response = array(
            'status' => $status,
            'code' => $code,
            'data' => $question
        );

        return $response;
    }

    public function update(Request $request, $id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        try{    

            $question = Question::findOrFail($id);
            $question->category = $request->category;
            $question->title = $request->title;
            $question->description = $request->description;

            $question->save();

            $data = array("question_id" => $question->id);

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
            $data = Question::destroy($id);
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

    public function questionsByUser($id)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        $data = Question::where('user_id', '=', $id)->get();

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

    public function questionsBySearching($searchingTerm)
    {
        $status = "Success";
        $code = 200;
        $data = array();

        $keywords = explode(" ", $searchingTerm);
        $result = Question::query();

        $filteredKeywords = array_filter($keywords, function($word) {
            return strlen($word) > 2;
        });

        foreach($filteredKeywords as $word){
            $result->orWhere('title', 'LIKE', '%'.$word.'%');
        }
        
        $data = $result->get();

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
