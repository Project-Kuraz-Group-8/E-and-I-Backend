<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Startup;
use App\Models\Investor;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function user_profile_data($id) : JsonResponse {
        $data = User::where('id', $id)->first();
        if (!$data) {
            return response()->json(['message' => 'No user found.'], 404);
        }
        return response()->json($data);
    }

    public function delete_startup() {

    }


    private function fill_investor_info($request){
        $validator = Validator::make($request, [
            'investor_type' => 'required|string|max:40',
            'investment_experience' => 'required|string',
            'investment_interest' => 'required|integer',
            'company_description' => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $request['user_id'] = Auth::user()->id;
        Investor::create($request);
        return response()->json(['message' => 'Investor data created successfully.'], 201);
    }
    private function create_startup($request) : JsonResponse{
        $validator = Validator::make($request, [
            'title' => 'required|string|max:40',
            'description' => 'required|string',
            'team_members' => 'required|string',
            'goal_amount' => 'required|integer',
            'current_amount' => 'required|integer',
            'category' => 'string',
            'status' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $request['user_id'] = Auth::user()->id;
        Startup::create($request);
        return response()->json(['message' => 'Startup created successfully.'], 201);

    }
    public function filterer(Request $request) {
        $data = $request->all();
        if (Auth::user()->role === 'investor') {
            return $this->fill_investor_info($data);
        }
        else if (Auth::user()->role === 'entrepreneur') {
            return $this->create_startup($data);
        }
        else return response()->json(["message" => 'no such user exists.']);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
