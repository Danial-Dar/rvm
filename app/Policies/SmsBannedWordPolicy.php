<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SmsBannedWord;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmsBannedWordPolicy
{
    use HandlesAuthorization;


    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

          /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->role == "admin";
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsBannedWord  $smsbannedWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SmsBannedWord $smsbannedWord)
    {
        return $user->role == "admin";
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role == "admin";
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsBannedWord  $smsbannedWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SmsBannedWord $smsbannedWord)
    {
        return $user->role == "admin";
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsBannedWord  $smsbannedWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SmsBannedWord $smsbannedWord)
    {
        return $user->role == "admin";
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsBannedWord  $smsbannedWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SmsBannedWord $smsbannedWord)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsBannedWord  $smsbannedWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SmsBannedWord $smsbannedWord)
    {
        return $user->role == "admin";
    }
}
