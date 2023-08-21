<?php

namespace App\Observers;

use App\Models\Predictive\User;
use App\Models\PredictiveAgent;
use App\Models\Team;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\Predictive\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $agent = new PredictiveAgent();
        $agent->user_id = $user->id;
        $agent->status = 'active';
        $agent->save();

        $team = new Team();
        $team->name = $user->first_name.' '.$user->last_name;
        $team->user_default = true;
        $team->save();

        $user->teams()->sync($team->id);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\Predictive\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\Predictive\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\Predictive\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\Predictive\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
