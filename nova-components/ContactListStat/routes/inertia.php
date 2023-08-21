<?php

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;

/*
|--------------------------------------------------------------------------
| Tool Routes
|--------------------------------------------------------------------------
|
| Here is where you may register Inertia routes for your tool. These are
| loaded by the ServiceProvider of the tool. The routes are protected
| by your tool's "Authorize" middleware by default. Now - go build!
|
*/

// Route::get('/', function (NovaRequest $request) {
//     return inertia('ContactListStat');
// });
Route::get('{id}', function (NovaRequest $request, $id) {
    return inertia('contact-list-stat/{id}', [
        'id' => $id
    ]);
});