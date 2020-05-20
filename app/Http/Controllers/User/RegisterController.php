<?php


namespace App\Http\Controllers\User;


use Auth;
use App\User;
use App\Traits\Jwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{

    use RegistersUsers, Jwt;

    protected $model = 'User';

    public function create(Request $request)
    {
        $validation = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],  
        ];
        $invalid = $this->handleValidation($validation);
        if ($invalid){
            return $invalid;
        }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $token =  auth()->login($user);
        return $this->getTokenFromOtherAttributes();
    }

}


