<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserSettingsController extends Controller
{
    public function index()
    {
        // Retrieve the current user's settings
        $user = Auth::user();

        // Return the user's email and name
        return response()->json([
            'email' => $user->email,
            'name' => $user->name,
        ]);

    }
    //TO DO change x-www-form-urlencoded to form-data
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'old_password' => ['required', new MatchOldPassword],
            'password' => 'required|string|min:8',
        ]);


        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Settings updated successfully']);
    }

}
