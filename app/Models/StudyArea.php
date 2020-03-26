<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="StudyArea",
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
 *          property="unique_code",
 *          description="unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="is_active",
 *          description="is_active",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="study_level_unique_code",
 *          description="study_level_unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="study_field_unique_code",
 *          description="study_field_unique_code",
 *          type="string"
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
class StudyArea extends Model
{
    use SoftDeletes;

    public $table = 'study_areas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'english_title',
        'unique_code',
        'is_active',
        'study_level_unique_code',
        'study_field_unique_code'
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
        'unique_code' => 'string',
        'is_active' => 'boolean',
        'study_level_unique_code' => 'string',
        'study_field_unique_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'unique_code' => 'required',
        'is_active' => 'required',
        'study_level_unique_code' => 'required',
        'study_field_unique_code' => 'required'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'study_area_unique_code', 'unique_code');
    }

    public function study_field()
    {
        return $this->belongsTo(StudyField::class, 'study_field_unique_code', 'unique_code');
    }
}
