<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Startup;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function startupSearchAPI(Request $request) {
            $query = $request->input('title');
            $category = $request->input('category');
            $status = $request->input('status');
            $goal_amount = $request->input('goalAmount');
            $location = $request->input('location');
            
            // Perform the search using Laravel Scout
            $startups = Startup::search($query)->get();
            $startups->load('user:id,name,location');
            
            // Apply category filter if provided
            if ($category) {
                $startups = $startups->filter(function ($startup) use ($category) {
                    return $startup->category === $category;
                });
            }
        
            // Apply status filter if provided
            if ($status) {
                $startups = $startups->filter(function ($startup) use ($status) {
                    return $startup->status === $status;
                });
            }
            
            // Apply goal_amount filter if provided (Either greater or less.)
            if ($goal_amount) {
                $startups = $startups->filter(function ($startup) use ($goal_amount) {
                    return $startup->goal_amount >= $goal_amount;
                });
            }

            // Apply location filter if provided
            if ($location) {
                $startups = $startups->filter(function ($startup) use ($location) {
                    return $startup->user->location === $location;
                });
            }
            if (!$startups->isEmpty()) 
                return response()->json([
                    'results' => $startups,
                    'result_count' => $startups->count()
                ]);
            else return response()->json(['message' => 'No results found.']);
    }
    public function investorSearchAPI(Request $request) {
        $query = $request->input('term');
        $experience = $request->input('investment_experience');
        $type = $request->input('investor_type');
        $interest = $request->input('interest');

        $investors = Investor::search($query)->get();
        if ($experience) {
            $investors = $investors->filter(function ($investor) use ($experience) {
                return $investor->investment_experience >= $experience;
            });
        }
        if ($type) {
            $investors = $investors->filter(function ($investor) use ($type) {
                return $investor->investor_type === $type;
            });
        }
        if ($interest) {
            $investors = $investors->filter(function ($investor) use ($interest) {
                return $investor->investment_interest <= $interest;
            });
        }
        $investors->load('user');
        if (!$investors->isEmpty()) 
        return response()->json([
            'results' => $investors,
            'result_count' => $investors->count()
        ]);
        else return response()->json(['message' => 'No results found.']);
    }
}
