<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class MovieController extends Controller
{
    private $movieService;
    public function __construct(MovieService $movieService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->movieService = $movieService;
    }

    public function index(Request $request){
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->movieService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have movies'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function detail($id){
        try{
            $result = $this->movieService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have movies details'
                ], 404);
            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function store(Request $request){
        try {
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
            $created_at = $request->created_at;
            $update_at = $request->updated_at;

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'type_of_movie' => 'required',
                'range_age' => 'required',
                'dimension' => 'required',
                'range_of_movie' => 'required',
                'start_date' => 'required',
                'poster' => 'required',
                'actor' => 'required',
                'direct' => 'required',
                'description' => 'required',
                'trailer' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('movies')->insert([
                    'name' => $name,
                    'type_of_movie' => $type_movie,
                    'range_age' => $range_age,
                    'dimension' => $dimension,
                    'range_of_movie' => $range_of_movie,
                    'start_date' => $start_date,
                    'poster' => $poster,
                    'actor' => $actor,
                    'director' => $direct,
                    'description' => $description,
                    'trailer' => $trailer,
                    'created_at' => $created_at,
                    'updated_at' => $update_at,
                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Add movie successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add movie fail"
                    ], 404);
                }

            }
        }catch(\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function delete($id){
        try {
            $result = $this->movieService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have movies details'
                ], 404);
            }
        }catch (\Exception $err){
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function update(Request $request){
        try {
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

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Update successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'Update fail'
                ], 404);
            }
        }catch(\Exception $err) {
            response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }

    public function select() {
        try {
            $result = DB::select('SELECT id, name FROM `movies`');

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'data' => $result
                ], 404);
            }
        }catch(\Exception $err){
            response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
