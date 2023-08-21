<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCardPolicy
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
        return true;
    }

    public function view(User $user) {
        return true;
    }

    public function delete(User $user) {
        return true;
    }

    public function update() {
        return false;
    }
    public function create() {
        return true;
    }
}
