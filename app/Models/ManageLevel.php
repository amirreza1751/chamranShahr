<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="ManageLevel",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="management_title",
 *          description="management_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="english_management_title",
 *          description="english_management_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="manager_title",
 *          description="manager_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="english_manager_title",
 *          description="english_manager_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="level",
 *          description="level",
 *          type="number",
 *          format="number"
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
class ManageLevel extends Model
{
    use SoftDeletes;

    public $table = 'manage_levels';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'management_title',
        'english_management_title',
        'manager_title',
        'english_manager_title',
        'level'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'management_title' => 'string',
        'english_management_title' => 'string',
        'manager_title' => 'string',
        'english_manager_title' => 'string',
        'level' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'management_title' => 'required',
        'manager_title' => 'required',
        'level' => 'required|unique'
    ];

    public function getManagementTitleLevelAttribute()
    {
        return "{$this->management_title} {$this->level}";
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'management_title',
                'english_management_title',
                'manager_title',
                'english_manager_title',
                'level'
            ])
            ->all();

        return $retrieve;
    }

}
