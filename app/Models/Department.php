<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

/**
 * @SWG\Definition(
 *      definition="Department",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="english_title",
 *          description="english_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="path",
 *          description="path",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="manage_level_id",
 *          description="manage_level_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="deleted_at",
 *          description="deleted_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Department extends Model
{
    use SoftDeletes;

    public $table = 'departments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'english_title',
        'description',
        'path',
        'manage_level_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'english_title' => 'string',
        'description' => 'string',
        'path' => 'string',
        'manage_level_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'title' => 'required|string|max:191',
//        'english_title' => 'required|string|max:191',
//        'description' => 'required|string',
//        'path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'title' => 'nullable|string|max:191',
        'english_title' => 'nullable|string|max:191',
        'description' => 'nullable|string',
        'path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];
    public static $messages = [
        'title.string' => '?????????? ???? ?????????? ???????? ???????? ??????',
//        'title.required' => '?????????? ???? ???????? ????????',
        'title.max' => '???????????? ?????? ?????????? 191 ?????????????? ??????',
        'english_title.string' => '?????????? ?????????????? ???? ?????????? ???????? ???????? ??????',
//        'english_title.required' => '?????????? ?????????????? ???? ???????? ????????',
        'english_title.max' => '???????????? ?????? ?????????? ?????????????? 191 ?????????????? ??????',
        'description.string' => '?????????????? ???? ?????????? ???????? ???????? ??????',
//        'description.required' => '?????????????? ???? ???????? ????????',
        'path.image' => '?????????? ???? ?????????? ???????? ???????? ??????',
        'path.mimes' => '???????? ?????? ???????? ???????? ?????????? jpg ?? png ??????????',
        'path.uploaded' => '???????????? ?????? ???????? ???????? ?????????? 2MB ??????',
    ];

    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }

    public function study_field()
    {
        return $this->hasOne(StudyField::class);
    }

    public function notices()
    {
        return $this->morphMany(Notice::class, 'owner');
    }

    public function news()
    {
        return $this->morphMany(News::class, 'owner');
    }

    public function manager()
    {
        $manage_history = $this->morphMany(ManageHistory::class, 'managed')
            ->where('is_active', true)
            ->orderBy('begin_date', 'desc')->first();
        if (isset($manage_history)){
            return User::find($manage_history->manager_id);
        }
    }

    public function externalServices()
    {
        return $this->morphMany(ExternalService::class, 'owner');
    }

    /**
     * **** ATTENTION ****
     * if there is no image on public/storage/departments/departments_default_image.jpg then you must put a default image there,
     * if not, some functionality may doesn't work properly
     *
     * return default image path for departments which has no image yet
     *
     * @return string path of default image path
     *
     */
    public function getAbsolutePathAttribute()
    {
        $file =  new \Illuminate\Filesystem\Filesystem();

        if (isset($this->path) && $file->exists(base_path() . str_replace('storage', 'public/storage', $this->path)))
            return URL::to('/') . $this->path;
        else
            return URL::to('/') . env('DEFAULT_DEPARTMENT_IMAGE');
    }

    public function retrieveManager()
    {
        $manage_history = $this->morphMany(ManageHistory::class, 'managed')
            ->where('is_active', true)
            ->orderBy('begin_date', 'desc')->first();
        if (isset($manage_history)){
            return User::find($manage_history->manager_id)->retrieveAsManager();
        }
    }

    public function manage_level()
    {
        return $this->belongsTo(ManageLevel::class);
    }

    public function manage_history()
    {
        $manage_history = $this->morphMany(ManageHistory::class, 'managed')
            ->where('is_active', true)
            ->orderBy('begin_date', 'desc');
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'title',
                'english_title',
                'description',
                'path',
            ])
            ->all();
        $retrieve['manageLevel'] = $this->manage_level->retrieve();
        $retrieve['manager'] = $this->retrieveManager();
        if (isset($this->faculty)){
            $retrieve['faculty'] = $this->faculty;
        }
        if (isset($this->study_field)){
            $retrieve['studyField'] = $this->study_field;
        }

        return $retrieve;
    }

    public function retrieveWithManager(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'title',
                'english_title',
                'description',
                'path',
            ])
            ->all();
        $retrieve['manageLevel'] = $this->manage_level->retrieve();
        $retrieve['manager'] = $this->manager();

        return $retrieve;
    }
}
