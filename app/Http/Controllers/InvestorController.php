<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;
use App\Models\InvestmentInterest;
use App\Models\Investor;
use Illuminate\Support\Facades\Auth;
use App\Notifications\InvestmentNotification;

class InvestorController extends Controller
{
    public function investAPI(Request $request, $startup_id) {
        $amount = $request->input('amount');
        $startup = Startup::find($startup_id);
        $minimum_required_amount = (int)$startup->goal_amount - $startup->current_amount;
        if ($amount < $minimum_required_amount) {
            return response()->json(['message' => 'The amount you are investing is less than what is needed.'], 400);
        }
        $entrepreneur = $startup->user;
        $investor = Investor::where('user_id', '=', Auth::id())->first();

        $interest = new InvestmentInterest();
        $interest->startup_id = $startup_id;
        $interest->investor_id = $investor->id;
        $interest->interest_message = $investor->user->name . ' has shown interest in your project. Amount proposed: ' . $amount .  ' ETB.';
        $interest->status = 'pending';
        $interest->save();

        $entrepreneur->notify(new InvestmentNotification($investor, $startup_id, $amount));
        return response()->json(['message' => 'Investment request sent to the entrepreneur.']);
    }
}
