<?php

namespace App\Policies;

use App\Models\IncomingCallLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomingCallLogPolicy
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
        return $user->can('view-incoming-call-log');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IncomingCallLog  $incomingCallLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, IncomingCallLog $incomingCallLog)
    {
        if ($user->role == 'admin') {
            return $user->can('view-incoming-call-log');
        }
        else if ($user->role == 'user' && $user->id == $incomingCallLog->user_id) {
            return $user->can('view-incoming-call-log');
        }
        else{
            return false;
        }
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
     * @param  \App\Models\IncomingCallLog  $incomingCallLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, IncomingCallLog $incomingCallLog)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IncomingCallLog  $incomingCallLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, IncomingCallLog $incomingCallLog)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IncomingCallLog  $incomingCallLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, IncomingCallLog $incomingCallLog)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IncomingCallLog  $incomingCallLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, IncomingCallLog $incomingCallLog)
    {
        //
    }
}
