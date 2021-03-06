<?php
namespace App\Services;
use App\Models\Showtime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ShowtimeService{
    public function getAll($limit, $page, $keyword, $date, $time)
    {
        $data = Showtime::with(['room', 'movie'])
            ->whereIn('movie_id', function (Builder $q) use ($keyword) {
                $q->select('id')
                    ->from('movies')
                    ->where('name', 'like',"%{$keyword}%");
            })
            ->where('show_date', 'LIKE', "%{$date}%")
            ->where('show_time', 'LIKE', "%{$time}%")
            ->offset(($page - 1) * 10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['room'] = $data[$i]->room;
            $data[$i]['movie'] = $data[$i]->movie;
            unset($data[$i]['room_id']);
            unset($data[$i]['movie_id']);
        }
        return $data;
    }

    public function getDetail($id){
        $data = Showtime::find($id);
        $data['room'] = $data->room;
        $data['movie'] = $data->movie;
        unset($data['room_id']);
        unset($data['movie_id']);

        return $data;
    }

    public function delete($id){
        $result = DB::table('showtime')->delete($id);

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
