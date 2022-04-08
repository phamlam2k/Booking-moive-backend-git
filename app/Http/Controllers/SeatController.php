<?php

namespace App\Http\Controllers;

use App\Services\SeatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class SeatController extends Controller
{
    private $seatService;
    public function __construct(SeatService $seatService) {
        $this->middleware('auth:api');
        $this->seatService = $seatService;
    }

    public function index(Request $request){
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->seatService->getAll($limit, $page, $keyword);

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
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function detail($id) {
        try {
            $result = $this->seatService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have movies detail'
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
            $row = $request->row;
            $num_order = $request->num_order;
            $money = $request->money;
            $type_seat = $request->type_seat;
            $room_id = $request->room_id;
            $created_at = $request->created_at;
            $updated_at = $request->updated_at;

            $validator = Validator::make($request->all(), [
                'row' => 'required',
                'money' => 'required',
                'type_seat' => 'required',
                'room_id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                for ($i = 1; $i <= $num_order; $i++){
                    $data = DB::table('seats')->insert([
                        'row' => $row,
                        'order' => $i,
                        'money' => $money,
                        'type_seat' => $type_seat,
                        'room_id' => $room_id,
                        'created_at' => $created_at,
                        'updated_at' => $updated_at,
                    ]);
                }

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Add seat successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add seat fail"
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

    public function seatOfRoom($id) {
        try {
            $result = $this->seatService->seatOfRoom($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have seat detail'
                ], 404);
            }
        } catch(\Exception $err) {
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
