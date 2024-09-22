<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'username' => 'required|email',
                'password' => 'required|min:6|max:16',
            ]
        );
        
        $username = $request->input('username');
        $password = $request->input('password');

        try {
            DB::connection()->getPdo();

            echo 'Connection is Ok!';
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

    }

    public function logout()
    {
        return "logout";
    }
}
