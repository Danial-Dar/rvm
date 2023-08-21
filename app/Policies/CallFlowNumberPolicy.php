<?php

namespace App\Policies;

use App\Models\CallFLowNumber;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CallFlowNumberPolicy
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

    public function viewAny(User $user)
    {
        return $user->can('view-callzy-number');
    }

    // public function create(User $user)
    // {
    //     return $user->role == 'admin';
    // }

    // public function view(User $user)
    // {
    //     return $user->role == 'admin';
    // }

    public function delete(User $user)
    {
        return true;
    }
}
