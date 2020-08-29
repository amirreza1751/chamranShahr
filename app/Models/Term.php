<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;

/**
 * @SWG\Definition(
 *      definition="Term",
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
 *          property="unique_code",
 *          description="unique_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="term_code",
 *          description="term_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="begin_date",
 *          description="begin_date",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="end_date",
 *          description="end_date",
 *          type="string",
 *          format="date-time"
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
class Term extends Model
{
    use SoftDeletes;

    public $table = 'terms';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'unique_code',
        'term_code',
        'begin_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'unique_code' => 'string',
        'term_code' => 'string',
        'begin_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'unique_code' => 'required',
        'term_code' => 'required',
        'begin_date' => 'required',
        'end_date' => 'required'
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'entrance_term_unique_code', 'unique_code');
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'title',
                'unique_code',
                'term_code',
            ])
            ->all();
        $retrieve['begin_date'] = Jalalian::fromCarbon($this->begin_date)->format('Y-m-d');
        $retrieve['end_date'] = Jalalian::fromCarbon($this->end_date)->format('Y-m-d');
        return $retrieve;
    }

}
