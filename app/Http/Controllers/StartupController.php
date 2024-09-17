<?php
namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;
use App\Http\Resources\StartupResource;
use Illuminate\Support\Facades\Validator;

class StartupController extends Controller
{
    // Display a listing of startups
    public function index()
    {
        $startups = Startup::all();
        if ($startups ->count() > 0){
            return StartupResource::collection($startups);
        }else{
            return response()->json(['message' => 'No Startup is available'], 200);
        }
    }

    // Store a newly created startup in storage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'funding_stage' => 'required|string',
            'team_members' => 'required|string',
            'pitch_deck_url' => 'required|url',
            'business_plan_url' => 'required|url',
            'current_amount' => 'required|numeric',
            'goal_amount' => 'required|numeric',
            'category' => 'required|string',
            'visibility' => 'boolean',
            'status' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All field should be filled!',
                'errors' => $validator->messages(),
            ], 421);
        }

        
        $startup = Startup::create([
            'id'=>$request->id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'funding_stage' => $request->funding_stage,
            'team_members' => $request->team_members,
            'pitch_deck_url' => $request->pitch_deck_url,
            'business_plan_url' => $request->business_plan_url,
            'current_amount' => $request->current_amount,
            'goal_amount' => $request->goal_amount,
            'category' => $request->category,
            'visibility' => $request->visibility,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Startup created successfully',
            'data' => new StartupResource($startup)
        ], 201);
    }

    // Display the specified startup
    public function show($id)
    {
        $startup = Startup::findOrFail($id);
        return response()->json($startup);
    }

    // Update the specified startup in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'funding_stage' => 'required|string',
            'team_members' => 'required|string',
            'pitch_deck_url' => 'required|url',
            'business_plan_url' => 'required|url',
            'current_amount' => 'required|numeric',
            'goal_amount' => 'required|numeric',
            'category' => 'required|string',
            'visibility' => 'boolean',
            'status' => 'required|string',
        ]);

        $startup = Startup::findOrFail($id);
        $startup->update($validated);

        return response()->json($startup);

        
    }

    // Remove the specified startup from storage
    public function destroy($id)
    {
        $startup = Startup::findOrFail($id);
        $startup->delete();

        return response()->json(null, 204);
    }
}
