<?php

namespace App\Movies;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;

class MovieService{
    public function getAll($limit, $page, $keyword){
        $data = DB::table('movies')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

        return $data;
    }

    public function getDetail($id){
        $data = Movie::find($id);

        return $data;
    }
}
