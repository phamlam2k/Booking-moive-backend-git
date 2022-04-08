<?php

namespace App\Http\Controllers;

use App\Services\ShowtimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ShowtimeController extends Controller
{
    private $showtimeService;
    public function __construct(ShowtimeService $showtimeService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->showtimeService = $showtimeService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->showtimeService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have showtime'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function store(Request $request) {
        try {
            $show_date = $request->show_date;
            $show_time = $request->show_time;
            $room_id = $request->room_id;
            $movie_id = $request->movie_id;
            $created_at = $request->created_at;
            $updated_at = $request->updated_at;

            $validator = Validator::make($request->all(), [
                'show_date' => 'required',
                'show_time' => 'required',
                'room_id' => 'required',
                'movie_id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('showtime')->insert([
                    'show_date' => $show_date,
                    'show_time' => $show_time,
                    'room_id' => $room_id,
                    'movie_id' => $movie_id,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Add room successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add room fail"
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
}
