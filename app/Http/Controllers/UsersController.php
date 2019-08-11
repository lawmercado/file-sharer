<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request) {
        return 'UsersController::create';
    }

    public function profile(Request $request, $id) {
        $user = User::where('id', $id)->first();

        if( $user ) {
            if( $request->isMethod('post') ) {
                $this->validate($request, [
                    "old_password" => "required",
                    "password" => "required|confirmed|min:5"
                ]);

                if( Hash::check($request->input("old_password"), $user->password) ) {
                    $password = $request->input('password');

                    $user->password = User::encrypt($password);

                    if( $user->save() ) {
                        return $this->redirectWithSuccessMessage($request, "auth/logout", "Password updated! Log again with your new credentials.");
                    }
                }

                return $this->redirectWithErrorMessage($request, "users/$id/profile", "Unable to update the password. Verify your credentials and try again.");
            }

            return view('users/profile')->with('user', $user);
        }

        return $this->redirectWithErrorMessage($request, 'users/', "No user found!");
    }

    public function list(Request $request) {
        return view('users/list')->with('users', User::all());
    }

    public function delete(Request $request, $id) {
        $user = User::where('id', $id)->first();

        if( $user ) {
            if( $request->user()->isAdmin() )
            {
                $user->delete();
                
                return $this->redirectWithSuccessMessage($request, "users/", "The user was successfully deleted!");
            }
            else {
                return $this->redirectWithErrorMessage($request, "users/", "You have no permission to delete this file!");
            }
        }
        else {
            return $this->redirectWithErrorMessage($request, "users/", "The user does not exists!");
        }
    }
}
