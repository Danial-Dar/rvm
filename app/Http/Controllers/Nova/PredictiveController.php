<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\PredictiveAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PredictiveController extends Controller
{
    public function getAgents()
    {
        $agents = DB::table('agents')
            ->join('users', 'users.id', '=', 'agents.user_id')
            ->get();

        if (Auth::user()->role == 'user') {
            $agents = DB::table('agents')
            ->join('users', 'users.id', '=', 'agents.user_id')
            ->where('users.company_id', '=', Auth::user()->company_id)
            ->get();
        }
        return response()->json(['agents' => $agents],200);
    }
}
