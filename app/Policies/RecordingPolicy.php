<?php

namespace App\Policies;

use App\Models\Recording;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordingPolicy
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
        return $user->can('view-recording');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Recording $recording)
    {
        return $user->can('view-recording');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create-recording');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Recording $recording)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Recording $recording)
    {
        return $user->can('delete-recording');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Recording $recording)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Recording  $recording
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Recording $recording)
    {
        return $user->role == 'admin';  
    }
}
