<?php

namespace App\Services;
use App\Models\Movie;
use http\Env\Request;
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

    public function delete($id){
        $result = DB::table('movies')->delete($id);

        return $result;
    }

    public function update($request){
        $id = $request->id;
        $name = $request->name;
        $type_movie = $request->type_of_movie;
        $range_age = $request->range_age;
        $dimension = $request->dimension;
        $range_of_movie = $request->range_of_movie;
        $start_date = $request->start_date;
        $poster = $request->poster;
        $actor = $request->actor;
        $direct = $request->direct;
        $description = $request->description;
        $trailer = $request->trailer;

        $result = DB::update('update movies set name = ?, type_of_movie= ?, range_age= ?, dimension= ?, range_of_movie= ?, poster= ?, start_date= ?, actor= ?, director= ?, description= ?, trailer = ?  where id = ?', [$name,$type_movie, $range_age, $dimension, $range_of_movie,$poster, $start_date, $actor, $direct, $description, $trailer, $id]);

        return $result;
    }
}
