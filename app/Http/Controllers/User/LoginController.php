<?php


namespace App\Http\Controllers\User;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Traits\CustomResponse;
use Illuminate\Http\Request;
use App\Traits\Jwt;
use Exception;
use App\User;
use Auth;


class LoginController extends Controller
{
    use AuthenticatesUsers, Jwt, CustomResponse;

    protected $model = 'User';
    protected $resource = 'Auth';

    public function login(Request $request)
    {
        try {

            $validation = [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string']
            ];
    
            $validator = Validator::make(request()->all(),  $validation);
        
            if($validator->fails()){
    
                return $this->form_errors($validator->errors()->toArray());
    
            }
    
            $credentials = request(['email', 'password']);
    
            if (! $token = auth()->attempt($credentials)) {
    
                throw new Exception('Unauthorized. Check Credentials');
    
            }
    
            return $this->success('Login Successful', [
                'data' => $this->getTokenFromUserObject(),
            ], Response::HTTP_ACCEPTED);    
            
        } catch (Exception $e) {

            return $this->exception($e);

        }
    
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function all(){

        $user = User::all();
        return $user;
    }

}