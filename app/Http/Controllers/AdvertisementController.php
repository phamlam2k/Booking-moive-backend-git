<?php

namespace App\Http\Controllers;

use App\Services\AdvertisementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AdvertisementController extends Controller
{
    private $advertisementService;
    public function __construct(AdvertisementService $advertisementService) {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->advertisementService = $advertisementService;
    }

    public function index(Request $request) {
        try {
            $limit = $request->limit;
            $page = $request->page;
            $keyword = $request->keyword;
            $result = $this->advertisementService->getAll($limit, $page, $keyword);

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

    public function store(Request $request) {
        try {
            $name = $request->name;
            $image = $request->image;

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'required',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }else{
                $data = DB::table('advertisements')->insert([
                    'name' => $name,
                    'image' => $image,
                ]);

                if($data) {
                    return response()->json([
                        'status' => 1,
                        'message' => "Add advertisement successful"
                    ], 201);
                }else{
                    return response()->json([
                        'status' => 0,
                        'message' => "Add advertisement fail"
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

    public function delete($id) {
        try {
            $result = $this->advertisementService->delete($id);

            if($result){
                return response()->json([
                    'status' => 1,
                    'message' => 'Delete successful'
                ], 201);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => 'You dont have advertisement details'
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
            $image = $request->image;
            $name = $request->name;

            $result = DB::update('update advertisements set image = ?, name = ? where id = ?', [$image, $name, $id]);

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
        } catch(\Exception $exception){
            response()->json([
                'err' => $exception,
                'mess' => 'Something went wrong'
            ], 500);
        }
    }
}
