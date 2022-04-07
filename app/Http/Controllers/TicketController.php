<?php

namespace App\Http\Controllers;

use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    private $ticketService;
    public function __construct(TicketService $ticketService) {
        $this->middleware('auth:api');
        $this->ticketService = $ticketService;
    }

    public function orderTicket(Request $request) {
        try {
            $showtime_id = $request->showtime_id;
            $seats = $request->seats;
            $confirm = $request->confirm;
            $money = $request->money;
            $created_at = $request->created_at;
            $updated_at = $request->created_at;

            $arr_seats = explode(",", $seats);
            $arr_money = explode(',', $money);
            for($i = 0; $i < count($arr_seats); $i ++) {
                $result = DB::table('tickets')->insert([
                    'showtime_id' => $showtime_id,
                    'seats_id' => $arr_seats[$i],
                    'confirm' => $confirm,
                    'money' => $arr_money[$i],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ]);
            }

            if($result) {
                return response()->json([
                    'status' => 1,
                    'message' => "Order ticket successful"
                ], 201);
            }else {
                return response()->json([
                    'status' => 0,
                    'message' => "Order ticket fail please try again"
                ], 404);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'err' => $exception,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function pay(Request $request) {
        try {
            $confirm = $request->confirm;
            $id = $request->id;

            $result = DB::update('update tickets set confirm = ?,   where id = ?', [$confirm, $id]);

            if($result) {
                return response()->json([
                    'status' => 1,
                    'message' => "You buy ticket successful"
                ], 201);
            }else{
                return response()->json([
                    'status' => 1,
                    'message' => "You buy ticket fail"
                ], 404);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'err' => $exception,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }


}
