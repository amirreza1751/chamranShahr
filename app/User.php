<?php

namespace App;

use App\Models\Gender;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'birthday',
        'username',
        'gender_unique_code',
        'scu_id',
        'national_id',
        'is_verified',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'level_id',
        'role_id',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
    ];

    public static $rules = [
        'email' => 'unique:users',
        'username' => 'unique:users',
        'scu_id' => 'unique:users',
        'phone_number' => 'unique:users|required|regex:/(09)[0-9]{9}/|size:11',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
        'national_id' => 'unique:users',
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_unique_code', 'unique_code');
    }
}
