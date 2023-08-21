<?php

namespace Rvm\NumberOfStatesHeatmapCir;

use Carbon\Carbon;
use Laravel\Nova\Card;
use App\Models\ReputationHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NumberOfStatesHeatmapCir extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';


    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'number-of-states-heatmap-cir';
    }
}
