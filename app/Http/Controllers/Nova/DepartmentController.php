<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Scorecard;
use App\Models\Topic;
use Exception;
use Laravel\Nova\Http\Requests\NovaRequest;

class DepartmentController extends Controller
{
    public function index(NovaRequest $request)
    {
        if($request->user()->role == 'admin'){
            $departments = Department::all();
        }else{
            $user_id = $request->user()->id;
            $departments = Department::where('user_id',$user_id)->get();
        }

        return response()->json(['departments' => $departments, 'status' => true]);
    }

    
    public function indexTopics($id)
    {
        $topics = Topic::where('department_id',$id)->get();
        return response()->json(['topics' => $topics, 'status' => true]);
    }

    public function storeTopic(NovaRequest $request)
    {

        try {

            $title = $request->topic;
            $scorecard = $request->scorecard;
            $user_id = $request->user()->id;
            $status = true;


            Topic::create(['title' => $title, 'status' => $status, 'department_id' => $scorecard]);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => true]);
    }
    
}
