<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\SwNumber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Nova;

class UpdateAreaCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:areacode';

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
        $query = Balance::query();

        $query ->select(DB::raw("sum(-1 * balances.amount) as total, TRIM(TO_CHAR(balances.created_at, 'MM/DD/YYYY')) as date"));

        $query->groupBy('date','company_id');

        $query->whereRaw("type != 'PAYMENT'");

        dd($query->get()->toArray());
        $sw_numbers = SwNumber::whereNull('area_code')->get();

        foreach ($sw_numbers as $sw_number) {
            SwNumber::where('id', $sw_number->id)->update([
                'area_code' => $sw_number->phone_number[2].$sw_number->phone_number[3].$sw_number->phone_number[4]
            ]);
        }
    }
}
