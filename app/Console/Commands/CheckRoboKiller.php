<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SwNumber;

class CheckRoboKiller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filter:sw_numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $sw_numbers = SwNumber::get();

        foreach($sw_numbers as $sw_number) {
            if($this->parseNumber(str_replace('+','',$sw_number->phone_number))) {
                $sw_number->forceDelete();
            }
            sleep(10);
        }
    }

    public function parseNumber($phone_number)
    {
        $html = file_get_contents('https://lookup.robokiller.com/p/'.$phone_number);

        // Create a new DOMDocument object and load the HTML content

        // Create a new DOMDocument object and load the HTML content
            libxml_use_internal_errors(true);
            $doc = new \DOMDocument();
            $doc->loadHTML($html);
            libxml_use_internal_errors(false);

            // Create a new DOMXPath object to query the document
            $xpath = new \DOMXPath($doc);

            // Select the node containing the phone number
            $nodes = $xpath->query('//body//text()');

            // Convert the selected nodes to a string
            $text = '';
            foreach ($nodes as $node) {
            $text .= $node->nodeValue;
            }

            // Check if the text contains any negative words
            $negative_words = ['negative'];
            foreach ($negative_words as $word) {
                if (strpos(strtolower($text), $word) !== false) {
                    var_dump($phone_number);
                    return true;
                }
            }
            return false;
    }
}
