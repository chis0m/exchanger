<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\Auth\Register as RegisterRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\User;
use DB;

class RegisterController extends Controller
{
    use RegistersUsers;
    use ApiResponse;

    public function create(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $token = auth()->login($user);
            $data = $this->respondWithToken($token);
            DB::commit();
            return $this->success('Registration Successful', $data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respond($e);
        }
    }

    public function show()
    {
        return 'hello';
    }
}
