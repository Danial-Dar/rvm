<?php

namespace App\Http\Controllers\Nova\Recording;

use App\Models\Recording;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class RecordingController extends Controller
{
    public function index(Request $request) {

        \Log::error(Nova::user($request)->id);
        $user_id = Nova::user($request)->id;
        $role = Nova::user($request)->role;
        if($role == "user"){
            return Recording::where('status', 1)->where('user_id', Nova::user($request)->id)->get();
        }else{
            return Recording::where('status', 1)->get();
        }
        
    }
}