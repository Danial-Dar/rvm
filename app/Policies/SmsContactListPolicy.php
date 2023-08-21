<?php

namespace App\Policies;

use App\Models\SmsContactList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmsContactListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view-sms-contactlist');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SmsContactList $smsContactList)
    {
        return $user->can('view-sms-contactlist');
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // return $user->role === 'user';
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SmsContactList $smsContactList)
    {
        return $user->can('edit-sms-contactlist');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SmsContactList $smsContactList)
    {
        return $user->can('delete-sms-contactlist');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SmsContactList $smsContactList)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SmsContactList $smsContactList)
    {
        return $user->role == 'admin';
    }
}
