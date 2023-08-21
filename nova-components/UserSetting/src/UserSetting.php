<?php

namespace Rvm\UserSetting;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class UserSetting extends Tool
{
    public static $Route = '/user-setting';

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('user-setting', __DIR__.'/../dist/js/tool.js');
        Nova::style('user-setting', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @return mixed
     */
    public function menu(Request $request)
    {
        // return MenuSection::make('User Setting')
        //     ->path('/user-setting')
        //     ->icon('server');
    }
}
