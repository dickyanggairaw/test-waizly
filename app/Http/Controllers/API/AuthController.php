<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\PostResource;

class AuthController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login (Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        // $token = Auth::attempt($credentials);
        $token = auth()->guard('api')->attempt($credentials);
        
        if(!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        return new PostResource(true, 'successfully login data', [
            'user' => 'user',
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
            ]);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $dataUser = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($dataUser);

        return new PostResource(true, 'successfully create data', $user);
    }

    public function logout(){
        echo "disini functionlogout";
        Auth::logout();
        return new PostResource(true, 'successfully logout', [
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh(){
        return new PostResource(true, 'successfully login data', [
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer'
            ]
            ]);
    }
}
