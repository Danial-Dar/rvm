<?php

namespace App\Http\Controllers\Nova;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Aws;
use App\Jobs\AudioToText;
use App\Models\Agent;
use App\Models\Audio;
use App\Models\Group;
use App\Models\Note;
use App\Models\Phrase;
use App\Models\Scorecard;
use App\Models\Topic;
use Aws\S3\S3Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Http\Requests\NovaRequest;

class AudioController extends Controller
{
    public function index($id)
    {
        $audio = Audio::with('agent.topic.department', 'scorecard')->Where('id', $id)->first();

        $chatData = json_decode($audio->json_data);
        // $chatData = json_decode($audio->json_data);
        // $text = [];
        // foreach ($chatData as $data) {
        //     array_push($text,$data->text);
        // }
        // dd($text);

        // $topics = Topic::where('id', $audio->topic_id)->get();
        $scorecards = Scorecard::where('id', $audio->scorecard_id)->get();

        $notes = Note::where('call_id', $id)->with('user')->get();
        return response()->json(['chatData' => $chatData, 'scorecards' => $scorecards, 'notes' => $notes, 'filename' => $audio->filename, 'audio' => $audio]);
    }

    public function calls(NovaRequest $request, $type)
    {
        if ($request->user()->role == 'admin') {
            if ($type == 'processing') {
                $calls = Audio::with('agent', 'scorecard', 'note')->Where('status', 'pending')->get();
            } elseif ($type == 'flagged') {
                $calls = Audio::with('agent', 'scorecard', 'note')->Where('status', 'flagged')->get();
            } else {
                $calls = Audio::with('agent', 'scorecard', 'note')->get();
            }
        } else {
            $user_id = $request->user()->id;
            if ($type == 'processing') {
                $calls = Audio::with('agent', 'scorecard', 'note')->Where('status', 'pending')->where('user_id',$user_id)->get();
            } elseif ($type == 'flagged') {
                $calls = Audio::with('agent', 'scorecard', 'note')->Where('status', 'flagged')->where('user_id',$user_id)->get();
            } else {
                $calls = Audio::with('agent', 'scorecard', 'note')->where('user_id',$user_id)->get();
            }
        }


        return response()->json(['calls' => $calls]);
    }

    public function getCall($id)
    {
        $call = Audio::find($id);

        return response()->json(['call' => $call]);
    }

    public function filters(NovaRequest $request)
    {
        if ($request->user()->role == 'admin') {
            $groups = Group::get();
            $agents = Agent::get();
            $scorecards = Scorecard::get();
            $phrases = Phrase::get();

        }else{
            $user_id = $request->user()->id;

            $groups = Group::get();
            $agents = Agent::where('user_id',$user_id)->get();
            $scorecards = Scorecard::where('user_id',$user_id)->get();
            $phrases = Phrase::where('user_id',$user_id)->get();

        }

        return response()->json(['success' => true, 'groups' => $groups, 'agents' => $agents, 'scorecards' => $scorecards, 'phrases' => $phrases]);
    }
    public function filtersApply(NovaRequest $request, $type)
    {
        $query = Audio::query();

        if ($request->agents !== null) {
            $query->where('agent_id', $request->agents);
        }

        if ($request->scorecards !== null) {
            $query->where('scorecard_id', $request->scorecards);
        }

        if ($request->phrases !== null) {
            $phrase = Phrase::where('id', $request->phrases)->get()->pluck('topic_id');
            $query->whereIn('topic_id', $phrase);
        }

        if ($request->groups !== null) {
            $agent = Agent::where('group_id', $request->groups)->get()->pluck('id');
            $query->whereIn('agent_id', $agent);
        }

        if ($request->transcribed) {
            $query->where('status', 'success');
        }

        if ($request->pending) {
            $query->where('status', 'pending');
        }

        if ($request->flagged) {
            $query->where('status', 'flagged');
        }

        if ($request->processed) {
            $query->where('status', 'processed');
        }

        if ($request->valid) {
            $query->where('valid', true);
        }

        if ($request->invalid) {
            $query->where('valid', false);
        }

        if ($request->reviewed) {
            $query->where('is_reviewed', true);
        }

        if ($type == 'processing') {
            $calls = $query->with('agent', 'scorecard')->Where('status', 'pending')->get();
        } elseif ($type == 'flagged') {
            $calls = $query->with('agent', 'scorecard')->Where('status', 'flagged')->get();
        } else {
            $calls = $query->with('agent', 'scorecard')->get();
        }

        return response()->json(['success' => true, 'calls' => $calls]);
    }
    public function storeNote(NovaRequest $request)
    {

        try {

            $note = $request->note;
            $call_id = $request->call_id;
            $user_id = $request->user()->id;

            $insertion =  Note::create(['call_id' => $call_id, 'user_id' => $user_id, 'body' => $note]);
            DB::insert('insert into call_has_notes (audio_id, note_id) values (?, ?)', [$call_id, $insertion->id]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['success' => true]);
    }

    public function store(NovaRequest $request)
    {

        try {

            $agent_id = $request->agent_id;
            $scorecard_id = $request->scorecard_id;

            // dd($request->file);

            $filename = $this->uploadToAws($request->file);

            $user_id = $request->user()->id;

            $status = 'pending';

            $audio = new Audio();
            $audio->agent_id = $agent_id;
            $audio->scorecard_id = $scorecard_id;
            $audio->filename = $filename;
            $audio->status = $status;
            $audio->user_id = $user_id;
            $audio->job = $status;
            $audio->save();

            // Audio::create(['agent_id' => $agent_id, 'scorecard_id' => $scorecard_id, 'filename' => $filename, 'user_id' => $user_id, 'status' => $status, 'job' => $status]);

            AudioToText::dispatchAfterResponse($audio->id);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['success' => true]);
    }

    protected function uploadToAws($file)
    {
        $converted_path = $file;
        $filename = time() . '.' . 'wav';
        $ext = explode('.',$file->getClientOriginalName());


        if (end($ext) == "mp3") {

            // // window
            // $ffmpeg = \FFMpeg\FFMpeg::create([
            //     'ffmpeg.binaries'  => base_path().'/FFmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
            //     'ffprobe.binaries' => base_path().'/FFmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
            //     // 'timeout'          => 3600, // the timeout for the underlying process
            //     'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
            // ]);

            //ubuntu
            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => base_path() . '/FFmpeg/bin/ffmpeg', // the path to the FFMpeg binary
                'ffprobe.binaries' => base_path() . '/FFmpeg/bin/ffprobe', // the path to the FFProbe binary
                // 'timeout'          => 3600, // the timeout for the underlying process
                'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
            ]);

            $format = new \FFMpeg\Format\Audio\Wav();

            $audioFolderPath = storage_path() . '/app/recordings/qa/';

            try {
                $audioObj = $ffmpeg->open($file);
            } catch (\Exception $e) {

                throw new Exception($e->getMessage());
            }
            $audioObj->save($format, $audioFolderPath . $filename);

            $converted_path = storage_path('/app/recordings/qa/' . $filename);
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


        // $client = $this->ConnectAWS3();
        $client->putObject(
            [
                'Bucket' => 'RVM',
                'Key'    => $filename,
                'Body'   => file_get_contents($converted_path),
                // 'Body'   => file_get_contents($request->upload_audio),
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
            'Content-Type' => 'audio/mpeg'
        ]);

        $expiry = '+5 minutes';

        try {
            $request = $client1->createPresignedRequest($cmd, $expiry);
            $presignedUrl = (string) $request->getUri();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $filename;
    }
}
