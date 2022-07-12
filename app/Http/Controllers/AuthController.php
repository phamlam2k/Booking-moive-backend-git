<?php

namespace App\Http\Controllers;

use App\Mail\UserVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','re_register']]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'email' => 'required|string|email|max:100',
            'password' => 'required|string|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user['confirm'] == true)
                return response()->json([
                    'message' => 'Email existed',
                ], 401);
            else {
                return response()->json([
                    'message' => 'This api just use for registering the first time.Please use api re_register to reregister',
                ], 400);
            }
        }
        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'confirm' => false,
                'confirmation_code' => rand(100000, 999999),
                'confirmation_code_expired_in' => Carbon::now()->addSecond(60)
            ]
        ));
//        try {
        Mail::to($user->email)->send(new UserVerification($user));
        return response()->json([
            'message' => 'Registered,verify your email address to login',
            'user' => $user
        ], 201);
//        } catch (\Exception $err) {
//            $user->delete();
//            return response()->json([
//                'error' => $err,
//                'message' => 'Could not send email verification,please try again',
//            ], 500);
//        }
        return response()->json([
            'message' => 'Failed to create',
        ], 500);
    }

    public function re_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user['confirm'] == true)
                return response()->json([
                    'message' => 'Email existed',
                ], 401);
            else {
                $user->confirmation_code = rand(100000, 999999);
                $user->confirmation_code_expired_in = Carbon::now()->addSecond(60);
                $user->save();
                try {
                    Mail::to($user->email)->send(new UserVerification($user));
                    return response()->json([
                        'message' => 'Registered again,verify your email address to login ',
                        'user' => $user
                    ], 201);
                } catch (\Exception $err) {
                    $user->delete();
                    return response()->json([
                        'message' => 'Could not send email verification,please try again',
                    ], 500);
                }
            }
        }
        return response()->json([
            'message' => 'Failed to re_register',
        ], 500);
    }

    public function updateProfile(Request $request) {
        try {
            $id = $request->user_id;
            $full_name = $request->full_name;
            $number_phone = $request->number_phone;
            $address = $request->address;
            $birth = $request->birth;
            $gender = $request->gender;

            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|between:2,100',
                'number_phone' => 'string|between:10,20',
                'address' => 'required',
                'birth' => 'required|string|between:10,20',
                'gender' => 'required|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            } else {
                $result = DB::update('update users set full_name = ?, number_phone= ?, address= ?, birth= ?, gender= ? where id = ?', [$full_name, $number_phone, $address, $birth, $gender, $id]);

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
            }
        } catch (\Exception $err) {
            return response()->json([
                'err' => $err,
                'mess' => 'Something went wrong'
            ], 500);
        }

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $user = auth()->user();
        if ($user->confirm == false)
            return response()->json([
                "message" => "User is not verified"
            ], 400);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Carbon::parse(Carbon::now())->addSeconds(auth()->factory()->getTTL() * 60),
            'user' => auth()->user()
        ]);
    }
}
