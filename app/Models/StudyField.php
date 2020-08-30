<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="StudyField",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="unique_code",
 *          description="unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="faculty_unique_code",
 *          description="faculty_unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="department_id",
 *          description="department_id",
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
class StudyField extends Model
{
    use SoftDeletes;

    public $table = 'study_fields';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'unique_code',
        'faculty_unique_code',
        'department_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unique_code' => 'string',
        'faculty_unique_code' => 'string',
        'department_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'unique_code' => 'required',
        'faculty_unique_code' => 'required',
        'department_id' => 'required'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function study_areas()
    {
        return $this->hasMany(StudyArea::class, 'study_field_unique_code', 'unique_code');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_unique_code', 'unique_code');
    }

    public function students()
    {
        $students = collect();
        foreach ($this->study_areas as $studyArea){
            $students = $students->merge($studyArea->students);
        }
        return $students;
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'unique_code',
            ])
            ->all();
        $retrieve['department'] = $this->department;
        $retrieve['faculty'] = $this->faculty;

        return $retrieve;
    }

    public function retrieveWithDepartment(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'unique_code',
            ])
            ->all();
        $retrieve['department'] = $this->department->retrieveWithManager();

        return $retrieve;
    }

    public function getTitleAttribute()
    {
        return "{$this->department->title}";
    }
}
