<?php

namespace App\Services;
use App\Models\Seat;
use Illuminate\Support\Facades\DB;

class SeatService{
    public function getAll($limit, $page, $keyword){
        $data = DB::table('seats')
            ->where('type_seat', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

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
