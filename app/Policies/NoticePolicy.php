<?php

namespace App\Policies;

use App\User;
use App\Models\Notice;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class NoticePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the notice.
     *
     * @param  User  $user
     * @return mixed
     */
    public function anyView(User $user)
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
     * Determine whether the user can view the notice.
     *
     * @param  \App\User  $user
     * @param  \App\Notice  $notice
     * @return mixed
     */
    public function view(User $user, Notice $notice)
    {
        $manage_histories = $user->under_managment();

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
        elseif (!empty($manage_histories)){
            foreach ($manage_histories as $manage_history) {
                if(isset($notice->owner)){
                    if ($manage_history->managed == $notice->owner) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the notice.
     *
     * @param  \App\User  $user
     * @param  \App\Notice  $notice
     * @return mixed
     */
    public function store(User $user, Model $owner = null, User $creator = null)
    {
        $manage_histories = $user->under_managment();

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
        elseif($creator->id == $user->id){
            if (!empty($manage_histories)){
                foreach ($manage_histories as $manage_history) {
                    if(isset($owner)){
                        if ($manage_history->managed == $owner) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the notice.
     *
     * @param  \App\User  $user
     * @param  \App\Notice  $notice
     * @return mixed
     */
    public function update(User $user, Notice $notice)
    {
        $manage_histories = $user->under_managment();

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
        elseif (!empty($manage_histories)){
            foreach ($manage_histories as $manage_history) {
                if(isset($notice->owner)){
                    if ($manage_history->managed == $notice->owner) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the notice.
     *
     * @param  \App\User  $user
     * @param  \App\Notice  $notice
     * @return mixed
     */
    public function delete(User $user, Notice $notice)
    {
        $manage_histories = $user->under_managment();

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
        elseif (!empty($manage_histories)){
            foreach ($manage_histories as $manage_history) {
                if(isset($notice->owner)){
                    if ($manage_history->managed == $notice->owner) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Determine whether the user can restore the notice.
     *
     * @param  \App\User  $user
     * @param  \App\Notice  $notice
     * @return mixed
     */
    public function restore(User $user, Notice $notice)
    {

        if($user->hasRole('developer')){
            return true;
        }
//        elseif ($user->hasRole('admin')){
//            return true;
//        }
//        elseif ($user->hasRole('content_manager')){
//            return true;
//        }
//        elseif ($user->hasRole('notification_manager')){
//            return true;
//        }
//        elseif (!empty($user->under_managment())){
//            return true;
//        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the notice.
     *
     * @param  \App\User  $user
     * @param  \App\Notice  $notice
     * @return mixed
     */
    public function forceDelete(User $user, Notice $notice)
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
     * Determine whether the user can create notices.
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
     * Determine whether the user can create notices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function ajaxOwner(User $user)
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
}
