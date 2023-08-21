<?php

namespace App\Nova\Actions\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\User;
use App\Models\Company;

class ActivateUser extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        // $models = $models->transform(function ($item, $key) {
        //     return $item->id;
        // })->toArray();
        //$models->first()->id
        // dd($models->first()->id);
        $user = User::findorFail($models->first()->id);
        $user->status = 1;
        $user->save();
        if($user){
            $activeCompany = Company::find($user->company_id);
            $activeCompany->status = 1;
            $activeCompany->save();
        }
        
        return Action::message('User Activated Successfully');
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
