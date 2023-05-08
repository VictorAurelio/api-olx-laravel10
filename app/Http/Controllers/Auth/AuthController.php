<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\SignInRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(CreateUserRequest $request): JsonResponse
    {
        $data = $request->only(['name', 'email', 'password', 'state_id']);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        $response = [
            'error' => '',
            'token' => $user->createToken('Register_token')->plainTextToken,
        ];
        return response()->json($response);
    }
    public function signIn(SignInRequest $request): JsonResponse
    {
        $data = $request->only(['email', 'password']);

        if(!Auth::attempt($data)) {
            return response()->json(['error' => 'Invalid username or password']);
        }

        $user = Auth::user();
        $response = [
            'error' => '',
            'token' => $user->createToken('Register_token')->plainTextToken,
        ];        return response()->json($response);
    }
    public function signOut(): JsonResponse
    {
        return response()->json(['method' =>'signOut']);
    }
    public function userProfile(): JsonResponse
    {
        $user = Auth::user();
        $response = [
            'name' => $user->name,
            'email' => $user->email,
            'state' => $user->state->name,
            'advertisement' => $user->advertisements
        ];
        return response()->json($response);
    }
}
