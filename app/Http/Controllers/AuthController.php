<?php

namespace App\Http\Controllers;

use App\Helpers\ResponsesHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'create']]);
    }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|string|email:max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) return ResponsesHelper::validationErrors($validator->errors());
        try {
            $user = User::create([
                ...$request->all(),
                'password' => Hash::make($request->get('password')),
            ]);
            return ResponsesHelper::success("User created", 200, $user);
        } catch (\Exception $e) {
            return ResponsesHelper::error("Something wrong", 400, $e);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) return ResponsesHelper::validationErrors($validator->errors());

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return ResponsesHelper::error("Invalid credentials", 401);
        }

        return ResponsesHelper::success("Success", 200, ['user'=>$this->me(), 'auth_data'=>$this->respondWithToken($token)]);
    }

    public function me()
    {
        return auth()->user();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
