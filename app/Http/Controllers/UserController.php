<?php

namespace App\Http\Controllers;

use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $success = true;
            $message = 'Logged in!';
        } else {
            $success = false;
            $message = 'Wrong credentials!';
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
            'user' => Auth::user()
        ];
        return response()->json($response);
    }

    /**
     * Logout
     */

    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Logged out!';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

}
