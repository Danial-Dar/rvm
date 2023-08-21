<?php

namespace App\Console\Commands;

use App\Models\Agent;
use App\Models\Audio;
use App\Models\Phrase;
use App\Models\Scorecard;
use Illuminate\Console\Command;

class ProcessTextFromAudio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process text and apply words filter, bad words and other logics from phrase, topics and components';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $audios = Audio::where('status', 'success')->where('job', 'processed')->whereNotNull('json_data')->get();

        foreach ($audios as $audio) {
            if ($this->isJson($audio->json_data)) {
                $badWords = [];
                $requiredWords = [];
                $positiveWords = [];
                $negativeWords = [];
                $nsfwWords = [];
                $totalBanned = 0;
                $totalRequired = 0;
                $totalPositive = 0;
                $totalNegative = 0;
                $totalNsfw = 0;
                $score = 0;
                $data = json_decode($audio->json_data);
                foreach (json_decode($data, true) as $single) {
                    $emotion = $single['emotions'][0];
                    $speaker = $single['speaker'][0];
                    $text = $single['text'];
                    $time = $single['time'];

                    $scorecard = Scorecard::find($audio->scorecard_id);
                    if ($scorecard) {
                        $phrases = Phrase::where('scorecard_id', $scorecard->id)->get();
                        foreach ($phrases as $phrase) {

                            if ($phrase->flag_type == "0") //banned word
                            {
                                $name = $phrase->title;
                                if (strstr(strtolower($text), strtolower($name))) {
                                    array_push($badWords, $name);
                                }
                                $totalBanned = $totalBanned + 1;
                            }
                            if ($phrase->flag_type == "1") //required word
                            {
                                $name = $phrase->title;
                                if (strstr(strtolower($text), strtolower($name))) {
                                    array_push($requiredWords, $name);
                                }
                                $totalRequired = $totalRequired + 1;
                            }
                            if ($phrase->flag_type == "2") //positive word
                            {
                                $name = $phrase->title;
                                if (strstr(strtolower($text), strtolower($name))) {
                                    array_push($positiveWords, $name);
                                }
                                $totalPositive = $totalPositive + 1;
                            }
                            if ($phrase->flag_type == "3") //negative word
                            {
                                $name = $phrase->title;
                                if (strstr(strtolower($text), strtolower($name))) {
                                    array_push($negativeWords, $name);
                                }
                                $totalNegative = $totalNegative + 1;
                            }
                            if ($phrase->flag_type == "4") //nsfw word
                            {
                                $name = $phrase->title;
                                if (strstr(strtolower($text), strtolower($name))) {
                                    array_push($nsfwWords, $name);
                                }
                                $totalNsfw = $totalNsfw + 1;
                            }
                        }
                    }
                }
                $countBadWords = count($badWords);
                $countRequiredWords = count($requiredWords);
                $countPositiveWords = count($positiveWords);
                $countNegativeWords = count($negativeWords);
                $countNsfwWords = count($nsfwWords);

                $upAudio = Audio::find($audio->id);

                if ($upAudio) {
                    $upAudio->banned_count = $countBadWords;
                    $upAudio->req_found_count = $countRequiredWords;
                    $upAudio->positive_count = $countPositiveWords;
                    $upAudio->negative_count = $countNegativeWords;
                    $upAudio->nsfw_count = $countNsfwWords;

                    $upAudio->banned = json_encode($badWords);
                    $upAudio->req_found = json_encode($requiredWords);
                    $upAudio->positive = json_encode($positiveWords);
                    $upAudio->negative = json_encode($negativeWords);
                    $upAudio->nsfw = json_encode($nsfwWords);

                    if ($countBadWords > 0) {
                        $upAudio->bad_calls = true;
                    }
                    if ($countBadWords == 0 && $countRequiredWords > 0) {
                        $upAudio->valid = true;
                        $agent = Agent::find($upAudio->agent_id);
                        if ($agent) {
                            $agent->score = ($agent->score !== null) ? (int) $agent->score + 1 : $agent->score;
                            $agent->save();
                        }
                    }

                    $score = ($totalRequired !== 0) ? (float) (count($requiredWords) / $totalRequired) * 100 : $upAudio->score;
                    $upAudio->score = $score;
                    $upAudio->save();
                }
            }
        }
    }


    protected function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
