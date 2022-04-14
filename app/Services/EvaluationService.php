<?php

namespace App\Services;
use App\Models\Evaluation;
use http\Env\Request;
use Illuminate\Support\Facades\DB;

class EvaluationService{
    public function getAll($limit, $page, $keyword){
        $data = DB::table('evaluation')
            ->where('id', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

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
