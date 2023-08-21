<?php

namespace Rvm\MonitorNumberToTimeCir;

use Laravel\Nova\Card;

class MonitorNumberToTimeCir extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    public $name="Numbers Monitored As Time";


    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'monitor-number-to-time-cir';
    }
}
