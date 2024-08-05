<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request, $token)
    {
        $passwordReset = DB::table('users')->where('token', $token)->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid password reset token'], 400);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Incorrect e-mail address'], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'The password has been reset.']);
    }
}
