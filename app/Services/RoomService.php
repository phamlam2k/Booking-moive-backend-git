<?php

namespace App\Services;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomService{
    public function getAll($limit, $page, $keyword){
        $data = DB::table('rooms')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

        return $data;
    }

    public function getDetail($id){
        $data = Room::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('rooms')->delete($id);

        return $result;
    }

    public function update($request){
        $id = $request->id;
        $number_seat = $request->number_seat;
        $name = $request->name;

        $result = DB::update('update rooms set number_seat = ?, name = ? where id = ?', [$number_seat, $name, $id]);

        return $result;
    }
}
