<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
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

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;
            $seat = $request->seat;

            $result = $this->ticketService->getAll($limit, $page, $keyword, $seat);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have ticket'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function orderTicket(Request $request) {
        try {
            $showtime_id = $request->showtime_id;
            $seats = $request->seats;
            $confirm = $request->confirm;
            $money = $request->money;
            $user_id = $request->user_id;
            $created_at = $request->created_at;
            $updated_at = $request->created_at;

            $arr_seats = explode(",", $seats);
            $arr_money = explode(",", $money);

            for($i = 0; $i < count($arr_seats); $i ++) {
                $result = DB::table('tickets')->insert([
                    'showtime_id' => $showtime_id,
                    'seats_id' => $arr_seats[$i],
                    'user_id' => $user_id,
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
            $id_count = $request->id_count;
            $showtime = $request->showtime;

            $ar_id_count = explode(",", $id_count);
            for($i = 0; $i < count($ar_id_count); $i ++) {
                $result = DB::update('update tickets set confirm = ? where seats_id = ? and showtime_id = ?', [$confirm, $ar_id_count[$i], $showtime ]);
            }

            if($result) {
                return response()->json([
                    'status' => 1,
                    'message' => "You buy ticket successful"
                ], 201);
            }else{
                return response()->json([
                    'status' => 1,
                    'data' => $result,
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

    public function delete(Request $request) {
        try {
            $id_count = $request->id_count;
            $showtime = $request->showtime;
            $ar_id_count = explode(",", $id_count);

            for($i = 0; $i < count($ar_id_count); $i ++) {
                $result = DB::delete('DELETE FROM `tickets` WHERE seats_id = ? AND showtime_id = ?', [$ar_id_count[$i], $showtime]);
            }

            if($result) {
                return response()->json([
                    'status' => 1,
                    'message' => "You denied buy ticket successful"
                ], 201);
            }else{
                return response()->json([
                    'status' => 1,
                    'data' => $result,
                    'message' => "You denied buy ticket fail"
                ], 404);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'err' => $exception,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function ticketDetail(Request $request) {
        try {
            $user_id = $request->user_id;

            $data = DB::table('tickets')->where('user_id', 'LIKE', $user_id);

            if($data) {
                return response()->json([
                    'status' => 1,
                    'data' => $data
                ], 201);
            } else {
                return response()->json([
                    'status' => 1,
                    'message' => 'You dont have ticket'
                ], 201);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'err' => $exception,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function ticketByUserID(Request $request) {
        try {
            $user_id = $request->user_id;

            $data = Ticket::with(['showtime', 'user', 'seat'])->where('user_id', 'LIKE', $user_id)->get();

            for ($i = 0; $i < count($data); $i ++) {
                $data[$i]['showtime'] = $data[$i]->showtime;
                $data[$i]['user'] = $data[$i]->user;
                $data[$i]['seat'] = $data[$i]->seat;
                unset($data[$i]['user_id']);
                unset($data[$i]['showtime_id']);
                unset($data[$i]['seats_id']);
            }

            if($data) {
                return response()->json([
                    'status' => 1,
                    'user_id' => $user_id,
                    'data' => $data
                ], 201);
            } else {
                return response()->json([
                    'status' => 1,
                    'message' => 'You dont have ticket'
                ], 201);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'err' => $exception,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
