<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
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
        return $user->can('view-caller-id-setting');
        // return $user->role == 'admin';
    }

    public function view(User $user, Setting $setting) {
        return true;
    }

    public function create() {
        return false;
    }

    public function update(User $user) {
        return true;
    }
}
