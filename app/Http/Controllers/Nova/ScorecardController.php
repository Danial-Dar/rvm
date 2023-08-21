<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use App\Models\Scorecard;
use App\Models\Topic;
use Exception;
use Laravel\Nova\Http\Requests\NovaRequest;

class ScorecardController extends Controller
{
    public function index(NovaRequest $request)
    {
        if($request->user()->role == 'admin'){
            $scorecards = Scorecard::all();
        }else{
            $user_id = $request->user()->id;
            $scorecards = Scorecard::where('user_id',$user_id)->get();
        }
        return response()->json(['scorecards' => $scorecards, 'status' => true]);
    }

    
    public function indexPhrases($id)
    {
        $phrases = Phrase::where('scorecard_id',$id)->get();
        return response()->json(['phrases' => $phrases, 'status' => true]);
    }

    public function storePhrase(NovaRequest $request)
    {

        try {

            $phrase = $request->phrase;
            $scorecard = $request->scorecard;
            $user_id = $request->user()->id;
            $flagType = $request->flagType;


            Phrase::create(['title' => $phrase, 'flag_type' => $flagType , 'scorecard_id' => $scorecard, 'user_id' => $user_id, 'min_count' => $user_id, 'speaker' => $user_id, 'first_x' => $user_id, 'last_x' => $user_id ,'time' => $user_id]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => true]);
    }
    
}
