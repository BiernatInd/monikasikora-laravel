<?php

namespace App\Http\Controllers\AdminPanel\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function downloadUsersList()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ]);
    }
}
