<?php

namespace Rvm\FileDragDrop;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('file-drag-drop', __DIR__.'/../dist/js/field.js');
            Nova::style('file-drag-drop', __DIR__.'/../dist/css/field.css');
            Nova::style('file-drag-drop-dropzone', 'https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css');

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
