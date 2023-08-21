<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Aws;
use App\Models\CallFlow;
use App\Models\CallFlowStep;
use Aws\S3\S3Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CallFlowController extends Controller
{
    public function index()
    {
        $call_flows = CallFlow::all();

        return Response::json([
            'call_flows' => $call_flows
        ], 200);
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $file = null;
        if ($request->greeting_audio) {
            $file = $request->greeting_audio;
        }
        if ($request->voicemail_audio) {
            $file = $request->voicemail_audio;
        }
        if ($request->call_tree_audio) {
            $file = $request->call_tree_audio;
        }
        if($file !== null) {
            $converted_path = $file;
            $filename = time().'.'.'wav';
            if($file->extension() == "mp3"){
                $ffmpeg = \FFMpeg\FFMpeg::create([
                    'ffmpeg.binaries'  => '/usr/bin/ffmpeg', // the path to the FFMpeg binary
                    'ffprobe.binaries' => '/usr/bin/ffprobe', // the path to the FFProbe binary
                    'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
                ]);

                $format = new \FFMpeg\Format\Audio\Wav();

                $audioFolderPath= storage_path().'/app/recordings/';

                try{
                    $audioObj = $ffmpeg->open($request->recording_path);
                }catch(\Exception $e){

                    throw new Exception($e->getMessage());
                }
                $audioObj->save($format, $audioFolderPath.$filename);

                $converted_path = storage_path('/app/recordings/'.$filename);

            }
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
                'Body'   => file_get_contents($converted_path),
                // 'Body'   => file_get_contents($request->recording_path),
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
                $request = $client1->createPresignedRequest($cmd, $expiry);
                $presignedUrl = (string) $request->getUri();
            } catch(\Exception $e) {
                throw new Exception($e->getMessage());
            }

            $params['recording_path'] = $presignedUrl;
            $params['filename'] = $filename;


        }

        $call_flow_step = new CallFlowStep();
        $call_flow_step->name = $params['name'];
        $call_flow_step->call_flow_id = $params['call_flow_id'];
        $call_flow_step->step = $params['step'];
        $call_flow_step->call_flow_type = $params['call_flow_type'];
        $call_flow_step->call_flow_type_fields = json_encode($params);
        $call_flow_step->save();

        return response()->json(['status' => 'success', 'message' => 'Call Flow Step Created Successfully.']);
    }
}
