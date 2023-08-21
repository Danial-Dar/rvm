<?php

namespace Rvm\Campaignsendrates;

use Laravel\Nova\Card;
use App\Models\Campaign;
use App\Models\ContactList;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class Campaignsendrates extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    public function query(){
        return [];
    }
    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'campaignsendrates';
    }
}
