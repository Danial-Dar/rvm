<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\Scorecard;
use App\Models\Topic;
use Exception;
use Laravel\Nova\Http\Requests\NovaRequest;

class TopicController extends Controller
{
    public function index()
    {
        $scorecards = Scorecard::all();
        return response()->json(['scorecards' => $scorecards]);
    }
    public function store(NovaRequest $request)
    {

        try {

            $title = $request->title;
            $scorecard = $request->scorecard;
            $user_id = $request->user()->id;
            $status = true;


            Topic::create(['title' => $title, 'status' => $status, 'scorecard_id' => $scorecard]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['success' => true]);
    }
}
