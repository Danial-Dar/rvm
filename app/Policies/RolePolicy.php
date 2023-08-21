<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission as Permission;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function viewAny(User $user)
    {
        return $user->role == 'admin';
    }

    public function create()
    {
        return true;
    }

    public function view()
    {
        return true;
    }

    public function attachAnyPermission()
    {
        return true;
    }
}
