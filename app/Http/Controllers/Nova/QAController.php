<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Audio;
use App\Models\Balance;
use App\Models\Campaign;
use App\Models\Company;
use App\Models\Phrase;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QAController extends Controller
{
    public function getTopics()
    {
        return Topic::where('status', 1)->get();
    }

    public function addPhrase(Request $request)
    {
        try {
            $phrase = new Phrase;
            $phrase->user_id = Auth::user()->id;
            $phrase->topic_id = $request->topic_id;
            $phrase->title = $request->title;
            $phrase->min_count = $request->min_count;
            $phrase->speaker = $request->speaker;
            $phrase->flag_type = $request->flag_type;
            $phrase->is_reviewable = $request->is_reviewable;
            $phrase->is_non_scrolable = $request->is_non_scorable;
            $phrase->is_force_review = $request->is_force_review;
            $phrase->first_x = $request->location_first;
            $phrase->last_x = $request->location_last;
            $phrase->time = $request->time;
            $phrase->save();
            return response()->json([
                'success' => true,
                'message' => 'Phrase Added Successfully.',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->errorInfo[2],
            ], 200);
        }
    }
    public function getCallDetails()
    {
        $calls = Audio::with('user', 'agent')->get();
        return response()->json([
            'calls' => $calls
        ], 200);
    }

    public function getAgents()
    {
        // $time = Carbon::now()->startOfDay();

        // $campaign = Campaign::query();

        // $campaign = $campaign->Where('updated_at', '>=', $time)->Where('status', 'played')->pluck('company_id');

        // // dd($query);
        // $query = Company::WhereIn('id', $campaign)->count();
        // dd($query);

        $time = Carbon::now()->startOfDay();

        $balance = Balance::query();

        $balance = $balance->Where('created_at', '>=', $time)->Where('type', 'PAYMENT')->sum('amount');
        dd($balance);
        // $agents = Agent::all();
        // return response()->json([
        //     'agents' => $agents
        // ], 200);
    }
}
