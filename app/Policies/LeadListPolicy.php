<?php

namespace App\Policies;

use App\Models\LeadList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadList  $leadList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LeadList $leadList)
    {
        return $user->can('view-lead-list');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadList  $leadList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LeadList $leadList)
    {
        return $user->can('update-lead-list');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadList  $leadList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LeadList $leadList)
    {
        return $user->can('delete-lead-list');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadList  $leadList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LeadList $leadList)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadList  $leadList
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LeadList $leadList)
    {
        //
    }
}
