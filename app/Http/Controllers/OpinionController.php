<?php

namespace App\Http\Controllers;

use App\Services\OpinionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OpinionController extends Controller
{
    private $opinionService;
    public function __construct(OpinionService $opinionService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->opinionService = $opinionService;
    }

    public function index(Request $request){
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->opinionService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have opinion'
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
            $title = $request->title;
            $detail = $request->detail;
            $user_id = $request->user_id;
            $created_at = $request->created_at;
            $update_at = $request->updated_at;


            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'detail'  => 'required',
                'user_id'  => 'required',

            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('opinion')->insert([
                    'title' => $title,
                    'detail' => $detail,
                    'user_id' => $user_id,
                    'created_at' => $created_at,
                    'updated_at' => $update_at,
                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Add opinion successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add opinion fail"
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
            $result = $this->opinionService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have opinion details'
                ], 404);
            }
        }catch (\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function select() {
        try {
            $result = DB::select('SELECT id, name FROM `opinion`');

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'data' => $result
                ], 404);
            }
        }catch(\Exception $err){
            response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}


