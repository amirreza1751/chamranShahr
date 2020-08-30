<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'title' => 'required',
        'manage_level_id' => 'required'
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
        $retrieve['manager'] = $this->manager();
        if (isset($this->faculty)){
            $retrieve['faculty'] = $this->faculty;
        }
        if (isset($this->study_field)){
            $retrieve['studyField'] = $this->study_field;
        }

        return $retrieve;
    }
}
