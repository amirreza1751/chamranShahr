<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="ManageHierarchy",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="manage_type",
 *          description="manage_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="manage_id",
 *          description="manage_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="managed_by_type",
 *          description="managed_by_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="managed_by_id",
 *          description="managed_by_id",
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
class ManageHierarchy extends Model
{
    use SoftDeletes;

    public $table = 'manage_hierarchies';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'manage_type',
        'manage_id',
        'managed_by_type',
        'managed_by_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'manage_type' => 'string',
        'manage_id' => 'integer',
        'managed_by_type' => 'string',
        'managed_by_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'manage_type' => 'required',
        'manage_id' => 'required',
        'managed_by_type' => 'required',
        'managed_by_id' => 'required'
    ];

    
}
