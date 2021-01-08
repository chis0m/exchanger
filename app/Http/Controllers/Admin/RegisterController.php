<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Auth\Register as RegisterRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Admin;

class RegisterController extends Controller
{
    use RegistersUsers;
    use ApiResponse;

    public function create(RegisterRequest $request)
    {
        try {
            $user = Admin::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $token = auth()->login($user);
            $data = $this->respondWithToken($token);
            return $this->success('Registration Successful', $data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->respond($e);
        }
    }
}
