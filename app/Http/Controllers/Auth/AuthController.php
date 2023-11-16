<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }
    public function login(Request $request): JsonResponse
    {
        return $this->service->login($request->only('email', 'password'));
    }
    public function refresh(): JsonResponse
    {
        return $this->service->refreshAuthUserToken();
    }
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
