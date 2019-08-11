<?php

namespace App\Http\Controllers;

use Validator;
use Log;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller 
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function login() {
        return view('login');
    }

    public function register(Request $request) {
        if( $request->isMethod('post') ) {
            $this->validate($request, [
                "fullname" => "required",
                "username" => "required",
                "password" => "required|confirmed|min:5"
            ]);

            $user = new User;
            $user->fullname = $request->input('fullname');
            $user->username = $request->input('username');
            $user->password = User::encrypt($request->input('password'));

            if( $user->save() ) {
                return $this->redirectWithSuccessMessage($this->request, 'auth/login', "Welcome! Please log in into the system.");
            }

            return $this->redirectWithSuccessMessage($this->request, 'auth/login', "It was not possible to register right now. Try again later.");
        }

        return view('register');
    }

    public function logout(Request $request) {
        $cookie = new Cookie("token", null, -1);
        
        $request->session()->reflash();

        return redirect('auth/login')->withCookie($cookie);
    }

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    } 
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\Models\User   $user 
     * @return mixed
     */
    public function authenticate(User $user) {
        $this->validate($this->request, [
            "username" => "required",
            "password" => "required"
        ]);

        if($this->request->input("username") !== "admin") {
            $this->validate($this->request, [
                "username" => "email",
            ]);
        }

        $user = User::where("username", $this->request->input("username"))->first();

        if (!$user) {
            return $this->redirectWithErrorMessage($this->request, 'auth/login', "Invalid password.");
        }

        // Verify the password and generate the token
        if( Hash::check($this->request->input("password"), $user->password) ) {
            $token = $this->jwt($user);
            $exp = time() + 60*60;

            return redirect('files/')->withCookie(new Cookie("token", $token, $exp));
        }

        // Bad Request response
        return $this->redirectWithErrorMessage($this->request, 'auth/login', "Invalid username or password.");
    }
}