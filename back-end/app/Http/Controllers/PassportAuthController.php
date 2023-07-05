<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4|string|max:255',
            'email' => 'required|email:rfc',
            'password' => 'required|string||min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!auth()->attempt($data)) {
            throw new InvalidCredentialsException('Unauthorised');
        }

        $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

}
