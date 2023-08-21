<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OptOutWord;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptOutWordPolicy
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
     * @param  \App\Models\OptOutWord  $optOutWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OptOutWord $optOutWord)
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
     * @param  \App\Models\OptOutWord  $optOutWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OptOutWord $optOutWord)
    {
        return $user->role == "admin";
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OptOutWord  $optOutWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OptOutWord $optOutWord)
    {
        return $user->role == "admin";
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OptOutWord  $optOutWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, OptOutWord $optOutWord)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OptOutWord  $optOutWord
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, OptOutWord $optOutWord)
    {
        return $user->role == "admin";
    }
}