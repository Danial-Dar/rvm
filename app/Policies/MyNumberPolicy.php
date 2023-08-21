<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MyNumberPolicy
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

    public function viewAny(User $user) {
        return $user->can('view-number');
    }

    public function view(User $user) {
        return $user->can('view-number');
    }

    public function delete(User $user) {
        return $user->can('delete-number');
    }

    public function update() {
        return false;
    }
}
