<?php

namespace App;

use App\Models\Department;
use App\Models\Gender;
use App\Models\ManageHistory;
use App\Models\Student;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    use Authorizable;
    use HasRoles;
    use HasPushSubscriptions;

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
        'last_login',
        'avatar_path',
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
        'password' => 'regex:/^(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/|min:8|max:191',
        'confirm_password' => 'required|same:password',
        'national_id' => 'unique:users',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullNameScuIdAttribute()
    {
        return "{$this->first_name} {$this->last_name} {$this->scu_id}";
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_unique_code', 'unique_code');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

//    public function manage_history()
//    {
//        return $this->hasMany(ManageHistory::class, 'manager_id');
//    }
//
//    public function is_manager()
//    {
//        $manage_histories = $this->manage_history;
//        foreach ($this->manage_history as $manage_history){
//            if($manage_history->is_active == true){
//                return true;
//            }
//        }
//        return false;
//    }
//
//    public function is_manager_of()
//    {
//        return ManageHistory::where('manager_id', $this->id)
//            ->where('is_active', true)
//            ->orderBy('begin_date', 'desc')->first();
//    }

    public function under_managment()
    {
        return $this->hasMany(ManageHistory::class, 'manager_id')
            ->where('is_active', true)
            ->where('end_date', null)->get();

    }

    public function managements()
    {
        return ManageHistory::where('manager_id', $this->id)
            ->where('is_active', true)
            ->where('end_date', null)->get();
    }

    public function retrieveAsManager(){
        $retrieve = collect($this->toArray())
            ->only([
                'first_name',
                'last_name',
                'avatar_path',
            ])
            ->all();
        $retrieve['gender'] = $this->gender->retrieve();
        $retrieve['full_name'] = $this->full_name;

        return $retrieve;
    }




    /**
     * **** ATTENTION ****
     * if there is no image on public/profile/default.jpg then you must put a default image there,
     * if not, some functionality may doesn't work properly
     *
     * return default avatar path for users which has no avatar image yet
     *
     * @return string path of default avatar path
     *
     */
    public function avatar()
    {
        $file =  new \Illuminate\Filesystem\Filesystem();

        if (isset($this->avatar_path) && $file->exists(base_path() . str_replace('storage', 'public/storage', $this->avatar_path)))
            return URL::to('/') . $this->avatar_path;
        else
            return URL::to('/') . env('DEFAULT_AVATAR');
    }
}
