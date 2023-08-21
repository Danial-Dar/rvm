<?php

namespace App\Jobs;

use App\Models\Audio;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AudioToText implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $audio = Audio::Find($this->id);
        $base_url = "https://api.assemblyai.com/v2";

        $headers = array(
        "authorization: 0f341c7ced404fe08908ec5e1eceebb8" ,
        "content-type: application/json"
        );

        $path = "https://rvm.nyc3.digitaloceanspaces.com/RVM/".$audio->filename;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $base_url . "/upload");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($path));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $response_data = json_decode($response, true);
        $upload_url = $response_data["upload_url"];

        curl_close($ch);

        $data = array(
            "audio_url" => $upload_url, // You can also use a URL to an audio or video file on the web
            "speaker_labels" => True,
            "sentiment_analysis" => True
        );

        $url = $base_url . "/transcript";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($curl), true);

        curl_close($curl);

        $transcript_id = $response['id'];
        $polling_endpoint = "https://api.assemblyai.com/v2/transcript/" . $transcript_id;

        while (true) {
            $polling_response = curl_init($polling_endpoint);

            curl_setopt($polling_response, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($polling_response, CURLOPT_RETURNTRANSFER, true);

            $transcription_result = json_decode(curl_exec($polling_response), true);

            if ($transcription_result['status'] === "completed") {
                $utterances = $transcription_result['sentiment_analysis_results'];

                $audio->json_data = json_encode($utterances);
                $audio->status = "success";
                $audio->job = "completed";
                $audio->save();

                // echo json_encode($utterances);
                die();

            } else if ($transcription_result['status'] === "error") {
                throw new Exception("Transcription failed: " . $transcription_result['error']);
            } else {
                sleep(3);
            }
        }
    }
}
