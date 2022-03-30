<?php

namespace App\Services;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class SeatService{
    public function getAll($limit, $page, $keyword){
        $data = Seat::with(['room'])
            ->where('type_seat', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i ++){
            $data[$i]['room'] = $data[$i]->room;
            unset($data[$i]['room_id']);
        }
        return $data;
    }

    public function getDetail($id){
        $data = Seat::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('seats')->delete($id);

        return $result;
    }

    public function seatOfRoom() {

    }
}
