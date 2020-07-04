<?php


namespace App\Http\Controllers\User;


use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Traits\Jwt;
use App\User;


class RegisterController extends Controller
{

    use RegistersUsers, Jwt, CustomResponse;

    public function create(Request $request)
    {

        try {
            
            $validation = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:6'],  
            ];
    
            $validator = Validator::make(request()->all(),  $validation);
    
            if($validator->fails()){
    
                return $this->form_errors($validator->errors()->toArray());
    
            }
    
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $user = auth()->login($user);

            return $this->success('Registration Successful', [
                'data' => $this->getTokenFromUserObject(),
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {

            return $this->exception($e);

        }
        
    }

}


