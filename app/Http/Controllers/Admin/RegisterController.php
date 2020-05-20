<?php


namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Traits\Jwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{


    use RegistersUsers, Jwt;

    protected $model = 'Admin';

    public function create(Request $request)
    {
        $validation = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:6'],  
        ];
        $invalid = $this->handleValidation($validation);
        if ($invalid){
            return $invalid;
        }
        $user = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $token =  auth()->login($user);
        return $this->getTokenFromOtherAttributes();
    }

}


