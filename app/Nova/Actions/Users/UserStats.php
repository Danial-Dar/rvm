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
use App\Models\UserSetting;
class UserStats extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'User Stats';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        $user_id = $models->first()->id;
        $user = User::where('id',$user_id)->with('company')->withCount([
            // 'campaignStats',
            'campaignStats as total_contact_count' => function ($query) {
                $query->select(\DB::raw('SUM(contact_count) AS total_contact_count'));
            },
            'campaignStats as total_sent_count' => function ($query) {
                $query->select(\DB::raw('SUM(sent_count) AS total_sent_count'));
            },
            'campaignStats as total_initiated_count' => function ($query) {
                $query->select(\DB::raw('SUM(initiated_count) AS total_initiated_count'));
            },
            'campaignStats as total_success_count' => function ($query) {
                $query->select(\DB::raw('SUM(success_count) AS total_success_count'));
            },
            'campaignStats as total_failed_count' => function ($query) {
                $query->select(\DB::raw('SUM(failed_count) AS total_failed_count'));
            },
            'campaignStats as total_dnc_count' => function ($query) {
                $query->select(\DB::raw('SUM(dnc_count) AS total_dnc_count'));
            },
        ])->first();
        
        return Action::modal('UserStats', [
            'user' => $user,
        ]);
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
