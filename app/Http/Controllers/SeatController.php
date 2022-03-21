<?php

namespace App\Http\Controllers;

use App\Services\SeatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $order = $request->order;
            $type_seat = $request->type_seat;
            $room_id = $request->room_id;

            $validator = Validator::make($request->all(), [
                'row' => 'required',
                'order' => 'required',
                'type_seat' => 'required',
                'room_id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('rooms')->insert([
                    'row' => $row,
                    'order' => $order,
                    'type_seat' => $type_seat,
                    'room_id' => $room_id,
                ]);

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
}
