<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginMail;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $responseData = [
                'message' => 'You have logged in successfully',
                'user' => [
                    'id' => $user->id,
                    'user_name' => $user->user_name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ];

            $loginDetails['status'] = 'Successful login attempt';
            return response()->json($responseData, 200);
        }

        $loginDetails = [
            'email' => $request->email,
            'time' => now()->toDateTimeString(),
            'status' => 'Failed login attempt'
        ];

        Mail::to('regionalnisandomierz@op.pl')->send(new LoginMail($loginDetails));

        return response()->json(['message' => 'Invalid login'], 401);
    }
}
