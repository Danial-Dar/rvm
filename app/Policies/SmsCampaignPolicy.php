<?php

namespace App\Policies;

use App\Models\SmsCampaign;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmsCampaignPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SmsCampaign $smsCampaign)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SmsCampaign $smsCampaign)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SmsCampaign $smsCampaign)
    {
        return $user->role == 'admin';
        // return ($smsCampaign->status !== 'played') && $user->role == 'user' || $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SmsCampaign $smsCampaign)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SmsCampaign $smsCampaign)
    {
        return $user->role == 'admin';
    }
}
