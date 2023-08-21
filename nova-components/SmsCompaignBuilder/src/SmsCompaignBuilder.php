<?php

namespace Sms\SmsCompaignBuilder;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class SmsCompaignBuilder extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('sms-compaign-builder', __DIR__.'/../dist/js/tool.js');

        Nova::style('sms-compaign-builder', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        // return MenuSection::make('Sms Compaign Builder')
        //     ->path('/sms-compaign-builder')
        //     ->icon('server');
    }

    // public function renderNavigation()
    // {
    //     return view('sms-compaign-builder::navigation');
    // }
}
