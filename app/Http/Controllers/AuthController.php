<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $user = User::where('username', $username)
            ->where('deleted_at', NULL)
            ->first();

        if (empty($user)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('login-error', 'Username or password are incorrect.');
        }

        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('login-error', 'Username or password are incorrect.');
        }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
            ]
        ]);

        echo "LOGIN SUCCESS!";
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->to('/login');
    }
}
