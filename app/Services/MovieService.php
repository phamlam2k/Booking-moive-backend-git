<?php

namespace App\Services;
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

    public function add($request){
        $name = $request->name;
        $type_movie = $request->type_of_movie;
        $range_age = $request->range_age;
        $dimension = $request->dimension;
        $range_of_movie = $request->range_of_movie;
        $start_date = $request->start_date;
        $start_time = $request->start_time;
        $actor = $request->actor;
        $direct = $request->direct;
        $description = $request->description;
        $trailer = $request->trailer;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type_of_movie' => 'required',
            'range_age' => 'required',
            'dimension' => 'required',
            'range_of_movie' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'actor' => 'required',
            'direct' => 'required',
            'description' => 'required',
            'trailer' => 'required',
        ]);

        if($validator->fails()){
            return ["validate" => $validator];
        }else{
            $data = DB::table('')->insert([
                'name' => $name,
                'type_of_movie' => $type_movie,
                'range_age' => $range_age,
                'dimension' => $dimension,
                'range_of_movie' => $range_of_movie,
                'start_date' => $start_date,
                'start_time' => $start_time,
                'actor' => $actor,
                'direct' => $direct,
                'description' => $description,
                'trailer' => $trailer,
            ]);
            return $data;
        }
    }

    public function delete($id){
        $result = DB::table('movies')->delete($id);

        return $result;
    }
}
