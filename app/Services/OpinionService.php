<?php

namespace App\Services;
use App\Models\Opinion;
use Illuminate\Support\Facades\DB;

class OpinionService{
    public function getAll($limit, $page, $keyword){
        $data = DB::table('opinion')
            ->where('id', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

        return $data;
    }

    public function getDetail($id){
        $data = Opinion::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('opinion')->delete($id);

        return $result;
    }

}
