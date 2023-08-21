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
use App\Models\Recording;
use Aws\S3\S3Client;

class SurveyController extends Controller
{
    /**
     * Impersonate a user.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    
     public function store(NovaRequest $request){


        // $converted_path = $request->recording_path;
        $filename = time().'.'.'wav';


        $SPACES_KEY  = 'LXN3CWYQSMF7BNLWMOL4';
        $SPACES_SECRET = 'EQgbUayx5GvwNRRRbwYLH6p1KFjXLuBuWcqKv4DjYe4';
       
        $client = new S3Client([
            'version' => 'latest',
            'region'  => 'nyc3',
            'endpoint' => 'https://rvm.nyc3.digitaloceanspaces.com',
            'credentials' => [
                'key'    => $SPACES_KEY,
                'secret' => $SPACES_SECRET,
            ],

        ]);

        $client->putObject([
            'Bucket' => 'RVM',
            'Key'    => $filename,
            'Body'   => $request->file,
            'ACL'    => 'public-read',
            'headers' => [
                    'Content-Type' => 'audio/mpeg',
                    'Content-Disposition' => 'attachment'
                ],
            ],

        );
        

        $aws = new  Aws();

        $client1 = $aws->connect();

        $cmd = $client1->getCommand('GetObject', [
            'Bucket' => 'RVM',
            'Key'    => $filename,
            'Content-Type'=> 'audio/mpeg'
        ]);

        $expiry = '+5 minutes';

        try {
            $req = $client1->createPresignedRequest($cmd, $expiry);
            $presignedUrl = (string) $req->getUri();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $user = Nova::user($request);
        $user_id = $user->id;
        $company_id = $user->company_id;

        $recording = new Recording;
        $recording->name = $request->name . '_' . $user_id;
        $recording->user_id =  $user_id;
        $recording->recording_path =  'https://rvm.nyc3.digitaloceanspaces.com/RVM/' . $filename;
        $recording->status =  1;
        $recording->filename =  $filename;
        $recording->company_id =  $company_id;

        $recording->save();


        return response()->json([
            'status' => true,
            'id' => $recording->id
        ]);

     }
}
