<?php

namespace App\Policies;

use App\Models\Notice;
use App\User;
use App\Models\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the notification.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }
        elseif (!empty($user->under_managment())){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create notifications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }
        elseif (!empty($user->under_managment())){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function update(User $user, Notification $notification)
    {

        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function delete(User $user, Notification $notification)
    {

        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function restore(User $user, Notification $notification)
    {

        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function forceDelete(User $user, Notification $notification)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the notification.
     *
     * @param  \App\User  $user
     * @param  \App\Notification  $notification
     * @return mixed
     */
    public function showNotifyStudents(User $user)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }
        elseif (!empty($user->under_managment())){
            return true;
        }

        return false;
    }

    public function notifyStudents(User $user, String $notifier_type, int $notifier_id)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }

        /** Models example:
         * $manage_histories            :   ManageHistory
         * $notifier_model              :   Notice, News
         * $manage_history->managed     :   Department
         * $notifier                    :   an instance of Notice or News
         * $notifier->owner             :   Department
         */
        $manage_histories = $user->under_managment();
        $notifier_model = new $notifier_type();
        $notifier = $notifier_model::where('id', $notifier_id)->first();
        foreach ($manage_histories as $manage_history) {
            if(get_class($manage_history->managed) == get_class($notifier->owner) && $manage_history->managed->id == $notifier->owner->id){
                return true;
            }
        }

        return false;
    }

    public function send(User $user, String $notifier_type, int $notifier_id)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif ($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('notification_manager')){
            return true;
        }

        /** Models example:
         * $manage_histories            :   ManageHistory
         * $notifier_model              :   Notice, News
         * $manage_history->managed     :   Department
         * $notifier                    :   an instance of Notice or News
         * $notifier->owner             :   Department
         */
        $manage_histories = $user->under_managment();
        $notifier_model = new $notifier_type();
        $notifier = $notifier_model::where('id', $notifier_id)->first();
        foreach ($manage_histories as $manage_history) {
            if(get_class($manage_history->managed) == get_class($notifier->owner) && $manage_history->managed->id == $notifier->owner->id){
                return true;
            }
        }

        return false;

    }
}
