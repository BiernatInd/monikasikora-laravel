<?php

namespace App\Http\Controllers\AdminPanel\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    public function adminSettingsAccount()
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json(['message' => 'Administrator nie znaleziony'], 404);
        }

        return response()->json($admin);
    }

    public function adminChangePassword(Request $request, $userName)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8',
        ]);

        $user = User::where('user_name', $userName)->first();

        if (!$user) {
            return response()->json(['message' => 'Użytkownik nie znaleziony'], 404);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['Podane aktualne hasło jest niepoprawne.'],
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Hasło zostało zmienione pomyślnie']);
    }

    public function adminChangeEmail(Request $request, $userName)
    {
        $request->validate([
            'password' => 'required',
            'new_email' => 'required|email',
        ]);

        $user = User::where('user_name', $userName)->first();

        if (!$user) {
            return response()->json(['message' => 'Użytkownik nie znaleziony'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Podane hasło jest niepoprawne.'],
            ]);
        }

        $user->email = $request->new_email;
        $user->save();

        return response()->json(['message' => 'E-mail został zaktualizowany pomyślnie']);
    }
}
