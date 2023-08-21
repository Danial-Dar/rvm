<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Http\Helpers\Aws;
use App\Models\Campaign;
use App\Models\User;
use Aws\S3\S3Client;
use function GuzzleHttp\Promise\all;

class RecordingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        if (!$company_id){
//            TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }

//        $company = auth()->user()->company_id;
//        $company_users = User::where('company_id', $company)->get();
//        foreach ($company_users as $user) {
//            $user_id[] = $user->id;
//        }
        $recordings = Recording::Where('company_id', $company_id)->get();

        // $user_id = auth()->user()->id;
        // $recordings = Recording::Where('user_id', $user_id)->get();
        $path = Storage::path('recordings');
        return view('user.recordings.index', compact('recordings', 'path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function ConnectAWS3() {
        // dd("Hello");
        //$ci = & get_instance();
        //$ci->load->model('Common_Model');
        //$data = $ci->Common_Model->query_run("SELECT *FROM s3");
        $SPACES_KEY  = 'LXN3CWYQSMF7BNLWMOL4';
        $SPACES_SECRET = 'EQgbUayx5GvwNRRRbwYLH6p1KFjXLuBuWcqKv4DjYe4';
        try
        {

         return $client = new S3Client([
                'version' => 'latest',
                'region'  => 'nyc3',
                'endpoint' => 'https://rvm.nyc3.digitaloceanspaces.com',
                'credentials' => [
                    'key'    => $SPACES_KEY,
                    'secret' => $SPACES_SECRET,
                ],

            ]);
        // $objects = $client->listObjects([
        //     'Bucket' => 'simplicity',
        // ]);

        // foreach ($objects['Contents'] as $obj){
        //     echo $obj['Key']."<br/>";
        // }

     //    $client->putObject([
     //     'Bucket' => 'simplicity',
     //     'Key'    => 'i130a.pdf',
     //     'Body'   => file_get_contents(PDFTEMPLATE.'i130a.pdf'),
     //     'ACL'    => 'private'
     // ]);

        // $spaces = $client->listBuckets();
        // foreach ($spaces['Buckets'] as $space){
        //     echo $space['Name']."<br/>";
        // }
         } catch(Exception $e) {
            echo $e->getMessage();
        }
            // print_r($client);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;


        $request->validate([
            // 'file' => 'required|mimes:mp3,wav',
            'name' => 'required',
        ]);
        $name = $request->name;

        $file = $request->file;

        if($request->file->extension() == "mp3"){

            // window
            // $ffmpeg = \FFMpeg\FFMpeg::create([
            //     'ffmpeg.binaries'  => base_path().'/FFmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
            //     'ffprobe.binaries' => base_path().'/FFmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
            //     // 'timeout'          => 3600, // the timeout for the underlying process
            //     'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
            // ]);

            //ubuntu
            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => base_path().'/FFmpeg/bin/ffmpeg', // the path to the FFMpeg binary
                'ffprobe.binaries' => base_path().'/FFmpeg/bin/ffprobe', // the path to the FFProbe binary
                // 'timeout'          => 3600, // the timeout for the underlying process
                'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
            ]);
            // dd($ffmpeg);
            $format = new \FFMpeg\Format\Audio\Wav();

            $audioFolderPath= storage_path().'/app/recordings/';


            try{
                $audioObj = $ffmpeg->open($request->file);
            }catch(\Exception $e){

                throw new Exception($e->getMessage());
            }

            $filename = time().'.'.'wav';

            // dd($audioObj);
            $audioObj->save($format, $audioFolderPath.$filename);

            $converted_path = storage_path('/app/recordings/'.$filename);

            $file = \File::get($converted_path);

        }else{
            $converted_path = $request->file;
            $filename = time().'.'.'wav';
        }

        // $converted_path = storage_path('/app/recordings/'.$filename);

        // $file = \File::get($converted_path);

        // $type = \File::mimeType($converted_path);

        $client = $this->ConnectAWS3();

        // $filename1 = time().'.'.$request->file->extension();

        try {
            $client->putObject([
                'Bucket' => 'RVM',
                'Key'    => $filename,
                'Body'   => file_get_contents($converted_path),
                'ACL'    => 'public-read',
                'headers' => [
                        'Content-Type' => 'audio/mpeg',
                        'Content-Disposition' => 'attachment'
                    ],
                ],

            );
        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }

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


        $recording = new Recording;
        $recording->name = $name;
        $recording->user_id = $user_id;
        $recording->company_id = $company_id;
        $recording->recording_path = $presignedUrl;
        $recording->status = '1';
        $recording->filename = $filename;
        $recording->save();

        return redirect()->back()->with('success','Recording Added Successfully.');


    }

    public function ajaxStore(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;

        $name = $request->name;

        $file = $request->file;
        // dd($request->all());
        if($request->file->extension() == "mp3"){

            // window
            // $ffmpeg = \FFMpeg\FFMpeg::create([
            //     'ffmpeg.binaries'  => base_path().'/FFmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
            //     'ffprobe.binaries' => base_path().'/FFmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
            //     // 'timeout'          => 3600, // the timeout for the underlying process
            //     'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
            // ]);

            //ubuntu
            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => base_path().'/FFmpeg/bin/ffmpeg', // the path to the FFMpeg binary
                'ffprobe.binaries' => base_path().'/FFmpeg/bin/ffprobe', // the path to the FFProbe binary
                // 'timeout'          => 3600, // the timeout for the underlying process
                'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
            ]);
            // dd($ffmpeg);
            $format = new \FFMpeg\Format\Audio\Wav();

            $audioFolderPath= storage_path().'/app/recordings/';


            try{
                $audioObj = $ffmpeg->open($request->file);
            }catch(\Exception $e){

                throw new Exception($e->getMessage());
            }

            $filename = time().'.'.'wav';

            // dd($audioObj);
            $audioObj->save($format, $audioFolderPath.$filename);

            $converted_path = storage_path('/app/recordings/'.$filename);

            $file = \File::get($converted_path);

        }else{
            $converted_path = $request->file;
            $filename = time().'.'.'wav';
        }

        // $converted_path = storage_path('/app/recordings/'.$filename);

        // $file = \File::get($converted_path);

        // $type = \File::mimeType($converted_path);

        $client = $this->ConnectAWS3();

        // $filename1 = time().'.'.$request->file->extension();

        try {
            $client->putObject([
                'Bucket' => 'RVM',
                'Key'    => $filename,
                'Body'   => file_get_contents($converted_path),
                'ACL'    => 'public-read',
                'headers' => [
                        'Content-Type' => 'audio/mpeg',
                        'Content-Disposition' => 'attachment'
                    ],
                ],

            );
        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }

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

        $recording = new Recording;
        $recording->name = $name;
        $recording->user_id = $user_id;
        $recording->company_id = $company_id;
        $recording->recording_path = $presignedUrl;
        $recording->status = '1';
        $recording->filename = $filename;
        $recording->save();

        $user_id = auth()->user()->id;

        $recordingUpdated = Recording::Where('user_id', $user_id)->get();

        return response()->json(['recording'=>$recordingUpdated,'success'=>'Recording Added Successfully.']);


    }
    public function listen(Request $request){

        if($request->recording_id !== null)
        {
            $id = $request->recording_id;
            $recording = Recording::findorFail($id);

            $filename = $recording->filename;
        }else{
            $filename = $request->filename;
        }
        $presignedUrl = "https://rvm.nyc3.digitaloceanspaces.com/RVM/" . $filename;

        // $aws = new  Aws();

        // $client = $aws->connect();

        // $cmd = $client->getCommand('GetObject', [
        //     'Bucket' => 'RVM',
        //     'Key'    => $filename,
        //     'Content-Type'=> 'audio/mpeg'
        // ]);

        // try {
        //     $request = $client->createPresignedRequest($cmd, '+5 minutes');
        //     $presignedUrl = (string) $request->getUri();
        //     // dd($presignedUrl);
        // } catch(\Exception $e) {
        //     throw new Exception($e->getMessage());
        // }


        return response()->json($presignedUrl);

    }

    public function download($id)
    {
        $rec =Recording::where('id', $id)->first();
        $aws = new  Aws();

        $client = $aws->connect();

        $cmd = $client->getCommand('GetObject', [
            'Bucket' => 'RVM',
            'Key'    => $rec->filename,
            'Content-Type'=> 'audio/mpeg'
        ]);

        try {
            $request = $client->createPresignedRequest($cmd, '+5 minutes');
            $presignedUrl = (string) $request->getUri();
            // dd($presignedUrl);
        } catch(\Exception $e) {
            throw new Exception($e->getMessage());
        }
        return redirect($presignedUrl,302)->withHeaders([
        'Content-Type' => 'audio/mpeg' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $audio = Recording::where('id',$id)->first();

        $campaigns = Campaign::WhereIn('status',['played', 'pending'])
                     ->Where('recording_id', $id)
                     ->count();
        // dd($campaigns);

        if($campaigns > 0){

            return redirect()->back()->with('error','This Recording is beign used in an active campaign.');

        }else{
            if($audio != null && isset($audio->filename)){
                $file_path = storage_path().'/app/recordings/'.$audio->filename;
                if(file_exists($file_path)){
                    unlink(storage_path('app/recordings/'.$audio->filename));
                }
            }
        }

        $audio->delete();
        return redirect()->back()->with('success','Recording deleted Successfully.');
    }
}
