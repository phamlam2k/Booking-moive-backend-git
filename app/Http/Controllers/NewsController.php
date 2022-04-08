<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class NewsController extends Controller
{
    private $newsService;
    public function __construct(NewsService $newsService) {
        $this->middleware('auth:api', ['except' => ['index', 'detail']]);
        $this->newsService = $newsService;
    }

    public function index(Request $request){
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;

            $result = $this->newsService->getAll($limit, $page, $keyword);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have news'
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
            $result = $this->newsService->getDetail($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'data' => $result
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have news details'
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
            $detail = $request->detail;
            $image = $request->image;
            $description = $request->description;
            $created_at = $request->created_at;
            $updated_at = $request->updated_at;

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'detail'  => 'required',
                'image'  => 'required',
                'description'  => 'required',
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('news')->insert([
                    'name' => $name,
                    'detail' => $detail,
                    'image' => $image,
                    'description' => $description,


                ]);

                if($data){
                    return response()->json([
                        'status' => 1,
                        'message' => "Add news successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add news fail"
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
            $result = $this->newsService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have news details'
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
            $detail = $request->detail;
            $image = $request->image;
            $description = $request-> description;


            $result = DB::update('update news set name = ?, detail =?, image =?, description =?,  where id = ?', [$name,$detail,$image,$description, $id]);

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
            $result = DB::select('SELECT id, name FROM `news`');

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
