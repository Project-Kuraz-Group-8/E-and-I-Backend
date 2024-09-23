<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Casts\Json;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
    public function loginAPI(Request $request): string {
        // Validate user data.
        $incomingFields = Validator::make($request->all(),[
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required'],
        ]);
        if ($incomingFields->fails()) {
            return response()->json($incomingFields->errors(), 422);
        }
        // Try to log in.
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = User::where('email', '=', $request->email)->first();
            $user_token = $user->createToken('e_and_i')->plainTextToken;
            return $user_token;
        }
        return response()->json([
            'message' => 'Invalid email or password.'
        ], 401);
    }
    public function registerAPI(Request $request): JsonResponse {
       
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|min:9',
            'role' => 'required',
            'location' => 'string'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'location' => $request->location,
        ]);
        return response()->json([
            'message' => 'User registered successfully!',
        ], 201);
    }
}
