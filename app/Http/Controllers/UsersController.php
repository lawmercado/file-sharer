<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request) {
        return 'UsersController::create';
    }

    public function get($id) {
        return 'UsersController::get';
    }

    public function list() {
        return view('users/list');
    }

    public function delete($id) {
        return 'UsersController::delete';
    }
}
