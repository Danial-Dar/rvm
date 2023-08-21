<?php

namespace App\Http\Controllers\Nova;

use App\Events\Disconnected;
use App\Events\Idle;
use App\Events\InCall;
use App\Events\OnHold;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\PredictiveAgent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function getCompanyAgents(Request $request)
    {
        $user = Auth::user();

        $agents = DB::table("users")
        ->Join('agents', 'users.id', '=', 'agents.user_id')
        ->Where('users.role', 'agent')
        ->Where('users.company_id', $user->company_id)
        ->Select("*")
        ->select(DB::raw('users.id as user_id, users.first_name as first_name, users.last_name as last_name, agents.id as id, agents.last_logged_in_time as logged_in_time, agents.status as status, agents.reporting_message as message'))
        ->paginate(3);

        return response()->json([
            'agents' => $agents
        ],200);
    }

    public function getCallStatus($id, $status)
    {
        $agent = PredictiveAgent::Where('user_id', $id)->first();
        if ($agent) {
            if ($status == 'in-call') {
                InCall::dispatch($agent->id);
            } elseif ( $status == 'on-hold') {
                OnHold::dispatch($agent->id);
            } elseif ( $status == 'idle') {
                Idle::dispatch($agent->id);
            } elseif ( $status == 'disconnected') {
                Disconnected::dispatch($agent->id);
            }
        }
        else {
            return response()->json([
                'error' => 'Agent Not Found'
            ],400);
        }
    }
}
