<?php

namespace App\Http\Controllers;

use App\Services\EvaluationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class EvaluationController extends Controller
{
    private $evaluationService;
    public function __construct(EvaluationService $evaluationService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->evaluationService = $evaluationService;
    }

    public function index(Request $request){
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->evaluationService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have evaluation'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function detail($id) {
        try {
            $result = $this->evaluationService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have evaluation detail'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function store(Request $request){
        try {
            $user_id = $request->user_id;
            $movie_id = $request->movie_id;
            $comment = $request->comment;
            $stars = $request->stars;


            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'movie_id' => 'required',
                'comment' => 'required',
                'stars' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('evaluation')->insert([
                    'user_id' => $user_id,
                    'movie_id' => $movie_id,
                    'comment' => $comment,
                    'stars' => $stars,

                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Add evaluation successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add evaluation fail"
                    ], 404);
                }
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
    public function delete($id){
        try {
            $result = $this->evaluationService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have evaluation details'
                ], 404);
            }
        }catch (\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
