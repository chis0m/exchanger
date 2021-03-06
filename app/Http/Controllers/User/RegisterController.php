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
use Exception;
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
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'first_login' => null,
                'base_currency_id' => null,
                'password' => Hash::make($request['password']),
            ]);

            $token = auth()->login($user);
            $data = $this->respondWithToken($token);
            DB::commit();
            return $this->success('Registration Successful', $data, Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollback();
            return $this->respond($e);
        }
    }

    public function show()
    {
        return 'hello';
    }
}
