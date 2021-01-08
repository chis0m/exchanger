<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\Auth\Login as LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Exception;
use Admin;
use Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use ApiResponse;

    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);
            if (! $token = auth()->attempt($credentials)) {
                throw new Exception('Unauthorized. Check Credentials', 401);
            }
            $data = $this->respondWithToken($token);
            return $this->success('Login Successful', $data, Response::HTTP_ACCEPTED);
        } catch (Exception $e) {
            return $this->respond($e);
        }
    }

    public function logout()
    {
        auth()->logout();
        return $this->success('Logout successful',[], 200);
    }
}
