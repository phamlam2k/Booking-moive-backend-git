<?php

namespace App\Services;
use App\Models\Evaluation;
use http\Env\Request;
use Illuminate\Support\Facades\DB;

class EvaluationService{
    public function getAll($limit, $page, $keyword){
        $data = Evaluation::with(['movie', 'user'])
            ->where('movie_id', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['movie'] = $data[$i]->movie;
            $data[$i]['user'] = $data[$i]->user;
            unset($data[$i]['user_id']);
            unset($data[$i]['movie_id']);
        }

        return $data;
    }

    public function getDetail($id){
        $data = Evaluation::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('evaluation')->delete($id);

        return $result;
    }

}
