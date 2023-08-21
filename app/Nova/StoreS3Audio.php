<?php

namespace App\Nova;

use App\Http\Helpers\Aws;
use Aws\S3\S3Client;
use Exception;
use Illuminate\Http\Request;

class StoreS3Audio
{
    /**
     * Store the incoming file upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $attribute
     * @param  string  $requestAttribute
     * @param  string  $disk
     * @param  string  $storagePath
     * @return array
     */
    public function __invoke(Request $request, $model, $attribute, $requestAttribute, $disk, $storagePath)
    {
        // if ($request->recording_path->extension() != "mp3" && $request->recording_path->extension() != "wav") {
        //     // return 'Please Upload .mp3 or .wav file';
        //     // dd('Please Upload .mp3 or .wav file');

        // }
        $converted_path = $request->recording_path;
        $filename = time().'.'.'wav';

        if($request->recording_path->extension() == "mp3"){

            // // window
            // $ffmpeg = \FFMpeg\FFMpeg::create([
            //     'ffmpeg.binaries'  => base_path().'/FFmpeg/bin/ffmpeg.exe', // the path to the FFMpeg binary
            //     'ffprobe.binaries' => base_path().'/FFmpeg/bin/ffprobe.exe', // the path to the FFProbe binary
            //     // 'timeout'          => 3600, // the timeout for the underlying process
            //     'ffmpeg.threads'   => 12,   // the number of threads that FFMpeg should use
            // ]);

            //ubuntu
            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => '/usr/bin/ffmpeg', // the path to the FFMpeg binary
                'ffprobe.binaries' => '/usr/bin/ffprobe', // the path to the FFProbe binary
                // 'timeout'          => 3600, // the timeout for the underlying process
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

        // $client = $this->ConnectAWS3();
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

        return [
            'recording_path' => $presignedUrl,
            'filename' => $filename,
            // 'attachment_size' => $request->attachment->getSize(),
        ];
    }
}
