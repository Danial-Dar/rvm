<?php

namespace Laravel\Nova\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Laravel\Nova\Contracts\ImpersonatesUsers;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Laravel\Nova\Util;
use App\Http\Helpers\Aws;
use App\Models\ApiSetting;
use App\Models\Recording;
use Aws\S3\S3Client;

class RecordingController extends Controller
{
    /**
     * Impersonate a user.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    
     public function store(NovaRequest $request){

        $user = Nova::user($request);
        $user_id = $user->id;
        $company_id = $user->company_id;
    
        $recordings = Recording::where('user_id',$user_id)->Where('status', '1')->get();

        return response()->json(['recordings' => $recordings, 'status' => true]);

     }
}
