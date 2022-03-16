<?php

namespace App\Http\Controllers;

use App\Movies\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private $movieService;
    public function __construct(MovieService $movieService) {
        $this->middleware('auth:api');
        $this->movieService = $movieService;
    }

    public function index(Request $request){
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->movieService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have movies'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err
            ], 500);
        }
    }

    public function detail($id){
        try{
            $result = $this->movieService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have movies details'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err
            ], 500);
        }
    }
}
