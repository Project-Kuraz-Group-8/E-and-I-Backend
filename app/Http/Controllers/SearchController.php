<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchAPI($term) {
        $startups = Startup::search($term)->get();
        if ($startups) 
        return response()->json([
            'results' => $startups,
            'result_count' => $startups->count()
        ]);
        else return response()->json(['message' => 'No results found.']);
    }
}
