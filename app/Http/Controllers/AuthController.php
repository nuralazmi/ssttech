<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(Request $request): JsonResponse
    {
        if ($request->has('debug')) $this->setDebug(true);
        $this->addLog('Started login function');

        $this->addLog('Validatate check');
        $validate = Validator::make($request->all(), [
            'username' => 'required|string|exists:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validate->fails()) {
            $this->addLog('No validated');
            $this->addMessage($validate->messages());
            $this->setFailedParameters($validate->failed());
            $this->setStatusCode(400);
            return $this->apiResponse();
        }
        $this->addLog('Validated');
        if (!Auth::attempt([
            'username' => $request->post('username'),
            'password' => $request->post('password'),
        ])) return response()->json(['message' => 'Invalid parameters'], 401);

        $this->setData([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
        return $this->apiResponse();
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        $this->addMessage('Tokens revoked');
        return $this->apiResponse();
    }
}
