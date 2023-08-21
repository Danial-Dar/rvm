<?php

namespace App\Policies;

use App\Models\DNC;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DNCPolicy
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
        return $user->can('view-dnc');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DNC  $dNC
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DNC $dNC)
    {
        return $user->can('view-dnc');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-dnc');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DNC  $dNC
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DNC $dNC)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DNC  $dNC
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DNC $dNC)
    {
        return $user->can('delete-dnc');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DNC  $dNC
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DNC $dNC)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DNC  $dNC
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DNC $dNC)
    {
        return $user->role == 'admin';
    }
}
