<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @SWG\Definition(
 *      definition="Student",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="study_area_unique_code",
 *          description="study_area_unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="study_level_unique_code",
 *          description="study_level_unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="entrance_term_unique_code",
 *          description="entrance_term_unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="study_status_unique_code",
 *          description="study_status_unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="total_average",
 *          description="total_average",
 *          type="number",
 *          format="number"
 *      ),
 *      @SWG\Property(
 *          property="is_active",
 *          description="is_active",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="is_guest",
 *          description="is_guest",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="is_iranian",
 *          description="is_iranian",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="in_dormitory",
 *          description="in_dormitory",
 *          type="boolean"
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
class Student extends Model
{
    use SoftDeletes;
    use Notifiable;

    public $table = 'students';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'study_area_unique_code',
        'study_level_unique_code',
        'entrance_term_unique_code',
        'study_status_unique_code',
        'total_average',
        'is_active',
        'is_guest',
        'is_iranian',
        'in_dormitory'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'study_area_unique_code' => 'string',
        'study_level_unique_code' => 'string',
        'entrance_term_unique_code' => 'string',
        'study_status_unique_code' => 'string',
        'total_average' => 'float',
        'is_active' => 'boolean',
        'is_guest' => 'boolean',
        'is_iranian' => 'boolean',
        'in_dormitory' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'study_area_unique_code' => 'required',
        'study_level_unique_code' => 'required',
        'entrance_term_unique_code' => 'required',
        'study_status_unique_code' => 'required',
        'is_active' => 'required',
        'is_guest' => 'required',
        'is_iranian' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function study_area()
    {
        return $this->belongsTo(StudyArea::class, 'study_area_unique_code', 'unique_code');
    }

    public function study_level()
    {
        return $this->belongsTo(StudyLevel::class, 'study_level_unique_code', 'unique_code');
    }

    public function entrance_term()
    {
        return $this->belongsTo(Term::class, 'entrance_term_unique_code', 'unique_code');
    }

    public function study_status()
    {
        return $this->belongsTo(StudyStatus::class, 'study_status_unique_code', 'unique_code');
    }
}
