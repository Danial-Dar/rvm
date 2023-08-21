<?php

namespace App\Policies;

use App\Models\ApiSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiSettingPolicy
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
        return $user->can('view-api-setting');
        // return $user->role == 'admin';
    }

    public function view(User $user, ApiSetting $api_setting) {
        return strtolower($api_setting->slug) == strtolower('bot');
    }

    public function create() {
        return false;
    }

    public function update(User $user) {
        return true;
    }
}
