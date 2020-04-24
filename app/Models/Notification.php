<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Notification",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="brief_description",
 *          description="brief_description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="notifiable_type",
 *          description="notifiable_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="notifiable_id",
 *          description="notifiable_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="notifier_type",
 *          description="notifier_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="notifier_id",
 *          description="notifier_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="deadline",
 *          description="deadline",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="data",
 *          description="data",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="read_at",
 *          description="read_at",
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
class Notification extends Model
{
    use SoftDeletes;

    public $table = 'notifications';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'brief_description',
        'type',
        'notifiable_type',
        'notifiable_id',
        'notifier_type',
        'notifier_id',
        'deadline',
        'data',
        'read_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'title' => 'string',
        'brief_description' => 'string',
        'type' => 'string',
        'notifiable_type' => 'string',
        'notifiable_id' => 'integer',
        'notifier_type' => 'string',
        'notifier_id' => 'integer',
        'deadline' => 'datetime',
        'data' => 'string',
        'read_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'notifiable_type' => 'required',
        'notifiable_id' => 'required',
        'notifier_type' => 'required',
        'notifier_id' => 'required'
    ];

    public function notifier()
    {
        return $this->morphTo();
    }

    public function notifiable()
    {
        return $this->morphTo();
    }
}
