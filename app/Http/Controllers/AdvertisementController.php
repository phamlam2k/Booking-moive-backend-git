<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function __construct() {
        $this->middleware('advertise:api', ['except' => ['index']]);
    }

    public function index(){
        $result = Advertisement::all();

        return response()->json([
            'status' => 1,
            'user' => $result
        ], 201);
    }
}
