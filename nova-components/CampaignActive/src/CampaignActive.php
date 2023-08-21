<?php

namespace Rvm\CampaignActive;

use Laravel\Nova\Card;

class CampaignActive extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/2';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'campaign-active';
    }
}
