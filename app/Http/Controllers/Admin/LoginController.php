<?php


namespace App\Http\Controllers\Admin;


use Auth;
use App\Traits\Jwt;
// use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers, Jwt;

    protected $model = 'Admin';

    public function login(Request $request)
    {
        $validation = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string']
        ];
        $invalid_credentials = $this->handleValidation($validation);
        if ($invalid_credentials){
            return $invalid_credentials;
        }
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->error('Unauthorized. Check Credentials', 401);
        }

        return $this->getTokenFromOtherAttributes();
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}

