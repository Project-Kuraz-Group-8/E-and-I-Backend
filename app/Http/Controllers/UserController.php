<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Startup;
use App\Models\Investor;
use Illuminate\Http\Request;
use App\Models\InvestmentInterest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\InvestmentAccepted;
use App\Notifications\InvestmentRejected;
use Illuminate\Notifications\DatabaseNotification;

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
            return response()->json([
                'token' => $token
            ]);
        }
        return response()->json([
            'message' => 'Invalid email or password'
        ], 401);
    }

    public function registerAPI(Request $request) {
        $incoming_fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required|string',
            'location' => 'required|string',
            'phone_number' => 'required|string',
            'bio' => 'nullable|string',
        ]);
        User::create($incoming_fields);
        return redirect('/login');
    }
    public function getNotifications() {
        $user = Auth::user();
        return response()->json($user->notifications);
    }
    public function investmentResponse(Request $request, $notification_id) {
        $user = Auth::user();
        $notification = DatabaseNotification::find($notification_id);
        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }
        $data = $notification->data;
        $response = $request->input('response');
        $investor_id = $data['investor_id'];
        $startup_id = $data['startup_id'];
        $startup = Startup::where('id', '=', $startup_id)->first();
        $entrepreneur = $startup->user;
        $investment = InvestmentInterest::where('startup_id', '=', $startup_id)->where('investor_id', '=', $investor_id)->where('status', '=', 'pending')->first();
        $investor = Investor::where('id', '=', $investor_id)->first();
        $user = $investor->user;
        if (!$investment) {
            return response()->json(['error' => 'No matching investment found'], 404);
        }
        if ($response === 'accept') {
            $investment->update(['status' => 'accepted']);
            $user->notify(new InvestmentAccepted($entrepreneur, $startup_id, "Investment offer accepted."));
            return response()->json([
                'message' => 'Investment accepted.',
                'chat_data' => [
                    'investor_id' => $investor->id,
                    'entrepreneur_id' => $user->id,
                    'startup_id' => $startup_id,
                    ]
                ]);
            }
        else if ($response === 'reject') {
            $investment->update(['status' => 'rejected']);
            $user->notify(new InvestmentRejected($entrepreneur, $startup_id));
            return response()->json([
                'message' => 'Investment rejected.'
                ]);
            }
        else {
            return response()->json(['message' => 'Invalid response.'], 400);
        }

    }

}
