<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function loginAPI(Request $request){
        $incoming_fields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($incoming_fields)){
            $user = User::where('email', $incoming_fields['email'])->first();
            $token = $user->createToken('e_and_i')->plainTextToken;
            return $token;
        }
        return "Ere lash embiyew ale";
    }

    public function registerAPI(Request $request) {
        $incoming_fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|string',
            'location' => 'required|string',
            'phone_number' => 'required|string',
            'bio' => 'required|string',
        ]);
        User::create($incoming_fields);
        return redirect('/login');
    }

    public function register(Request $request) {

    }
}
