<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Gender",
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
class Gender extends Model
{
    use SoftDeletes;

    public $table = 'genders';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'english_title',
        'unique_code'
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
        'unique_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'english_title' => 'required',
        'unique_code' => 'required'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'gender_unique_code', 'unique_code');
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'title',
                'english_title',
                'unique_code'
            ])
            ->all();

        return $retrieve;
    }
}
