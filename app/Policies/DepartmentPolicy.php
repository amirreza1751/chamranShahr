<?php

namespace App\Policies;

use App\Models\Department;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function view(User $user, Department $department)
    {
        //
    }

    /**
     * Determine whether the user can create departments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function update(User $user, Department $department)
    {
        //
    }

    /**
     * Determine whether the user can delete the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function delete(User $user, Department $department)
    {
        //
    }

    /**
     * Determine whether the user can restore the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function restore(User $user, Department $department)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the department.
     *
     * @param  \App\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function forceDelete(User $user, Department $department)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function showProfile(User $user)
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
        elseif ($user->hasRole('verified')){
            return true;
        }

        return false;
    }
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function updateProfile(User $user, Department $model)
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
        elseif ($user->hasRole('department_manager')){
            return true;
        }
        elseif (!is_null($model->manager())){
            if ($user->id == $model->manager()->id){ // if user request to update under management department
                return true;
            }
        }

        return false;
    }
}
