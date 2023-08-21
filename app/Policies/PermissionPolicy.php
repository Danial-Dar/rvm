<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
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

    public function create()
    {
        return true;
    }

    public function viewAny(User $user)
    {
        return $user->role == 'admin';
    }

    public function view(User $user, Permission $permission)
    {
        return true;
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->can('delete-permission');
    }
}
