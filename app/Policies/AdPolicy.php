<?php

namespace App\Policies;

use App\User;
use App\Models\Ad;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ad.
     *
     * @param  \App\User  $user
     * @param  \App\Ad  $ad
     * @return mixed
     */
    public function view(User $user, Ad $ad)
    {
        //
    }

    /**
     * Determine whether the user can create ads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the ad.
     *
     * @param  \App\User  $user
     * @param  \App\Ad  $ad
     * @return mixed
     */
    public function update(User $user, Ad $ad)
    {
        //
    }

    /**
     * Determine whether the user can delete the ad.
     *
     * @param  \App\User  $user
     * @param  \App\Ad  $ad
     * @return mixed
     */
    public function delete(User $user, Ad $ad)
    {
        //
    }

    /**
     * Determine whether the user can restore the ad.
     *
     * @param  \App\User  $user
     * @param  \App\Ad  $ad
     * @return mixed
     */
    public function restore(User $user, Ad $ad)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ad.
     *
     * @param  \App\User  $user
     * @param  \App\Ad  $ad
     * @return mixed
     */
    public function forceDelete(User $user, Ad $ad)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ad.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Ad  $ad
     * @return mixed
     */
    public function show_book_ad(User $user, Ad $ad)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->hasRole('verified')){
            return true;
        }
        else {
            return false;
        }
    }

    public function index_book_ad(User $user)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif($user->is_verified){
            return true;
        }
        else{
            return false;
        }
    }

    public function my_book_ads(User $user)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif($user->is_verified){
            return true;
        }
        else{
            return false;
        }
    }

    public function create_book_ad(User $user)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif($user->is_verified){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Determine whether the user can permanently delete the ad.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Ad  $ad
     * @return mixed
     */
    public function remove_book_ad(User $user, Ad $ad)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->id == $ad->creator->id){ // if user request to remove him/her Ads
            if ($user->hasRole('verified')){
                return true;
            }
        }
        else {
            return false;
        }
    }

    public function update_book_ad(User $user, Ad $ad)
    {
        if($user->hasRole('developer')){
            return true;
        }
        elseif($user->hasRole('admin')){
            return true;
        }
        elseif ($user->hasRole('content_manager')){
            return true;
        }
        elseif ($user->id == $ad->creator->id){ // if user request to update him/her Ads
            if ($user->hasRole('verified')){
                return true;
            }
        }

        return false;
    }
}
