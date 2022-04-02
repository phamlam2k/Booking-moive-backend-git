<?php

namespace App\Services;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsService{
    public function getAll($limit, $page, $keyword){
        $data = DB::table('movies')
            ->where('name', 'LIKE', "%{$keyword}%")
            ->offset(($page - 1)*10)
            ->paginate($limit);

        return $data;
    }

    public function getDetail($id){
        $data = News::find($id);

        return $data;
    }

    public function delete($id){
        $result = DB::table('news')->delete($id);

        return $result;
    }

    public function update($request){
        $id = $request->id;
        $name = $request->name;
        $detail = $request->detail;
        $image = $request->image;
        $description =$request->description;

        $result = DB::update('update movies set name = ?, detail =?, image =?, description =?,  where id = ?', [$name,$detail,$image,$description, $id]);

        return $result;
    }
}
