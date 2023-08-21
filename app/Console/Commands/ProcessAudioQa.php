<?php

namespace App\Console\Commands;

use App\Models\Audio;
use App\Models\IncomingCallLog;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use CURLFile;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessAudioQa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:qa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process audio files in QA module and transcribe them';

    private $basePath = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->basePath = storage_path('app/recordings/qa/job/');
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $audios = Audio::where('status', 'pending')->where('job', 'pending')->whereNotNull('filename')->get();

        foreach ($audios as $audio) {
            $filename = $audio->filename;
            $path = 'https://rvm.nyc3.digitaloceanspaces.com/RVM/' . $filename;
            $fileFetched = $this->get_file($path);
            if ($fileFetched) {
               $response =  $this->guzzle_request($path);

               $checkJson = $this->isJson($response);
                
                if($checkJson){
                   Audio::where('id',$audio->id)->update(['status' => 'success', 'json_data' => $response]);        
                }

            }
            Audio::where('id',$audio->id)->update(['job' => 'processed']);        

        }
    }

    protected function guzzle_request($path)
    {
        $client = new Client();
        $options = [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => new CURLFile($path),
                    'filename' => $path,
                    'headers'  => [
                        'Content-Type' => '<Content-type header>'
                    ]
                ]
            ]
        ];
        $request = new Request('POST', 'http://speech-diarization.voslogic.com/audio/upload');
        $res = $client->sendAsync($request, $options)->wait();
        $response =  $res->getBody()->getContents();

        return json_encode($response);
    }

    protected function get_file($file_url)
    {
        // Initialize a file URL to the variable
        try {

            $url = $file_url;

            // Initialize the cURL session
            $ch = curl_init($url);

            // Initialize directory name where
            // file will be save
            $dir = $this->basePath;

            // Use basename() function to return
            // the base name of file
            $file_name = basename($url);

            // Save file into file location
            $save_file_loc = $dir . $file_name;

            // Open file
            $fp = fopen($save_file_loc, 'wb');

            // It set an option for a cURL transfer
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            // Perform a cURL session
            curl_exec($ch);

            // Closes a cURL session and frees all resources
            curl_close($ch);

            // Close file
            fclose($fp);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

   protected function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
     }
}
