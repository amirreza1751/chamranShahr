<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Faculty",
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
class Faculty extends Model
{
    use SoftDeletes;

    public $table = 'faculties';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'unique_code',
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
        'department_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'unique_code' => 'required',
        'department_id' => 'required'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function study_fields()
    {
        return $this->hasMany(StudyField::class, 'faculty_unique_code', 'unique_code');
    }

    public function getTitleAttribute()
    {
        return "{$this->department->title}";
    }

    public function students()
    {
        $students = collect();
        foreach ($this->study_fields as $studyField){
            foreach ($studyField->study_areas as $studyArea){
                $students = $students->merge($studyArea->students);
            }
        }
        return $students;
    }

    public function studentsCount()
    {
        $count = $this->students()->count();
        return $count;
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'unique_code',
            ])
            ->all();
        $retrieve['department'] = $this->department->retrieveWithManager();
        $retrieve['studentsCount'] = $this->studentsCount();

        return $retrieve;
    }
}
