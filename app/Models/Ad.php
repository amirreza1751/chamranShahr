<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Ad",
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
 *          property="ad_location",
 *          description="ad_location",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="english_ad_location",
 *          description="english_ad_location",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="advertisable_type",
 *          description="advertisable_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="advertisable_id",
 *          description="advertisable_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="offered_price",
 *          description="offered_price",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="phone_number",
 *          description="phone_number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="is_verified",
 *          description="is_verified",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="is_special",
 *          description="is_special",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="category_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="ad_type_id",
 *          description="ad_type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="creator_id",
 *          description="creator_id",
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
class Ad extends Model
{
    use SoftDeletes;

    public $table = 'ads';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'english_title',
        'ad_location',
        'english_ad_location',
        'advertisable_type',
        'advertisable_id',
        'offered_price',
        'phone_number',
        'description',
        'is_verified',
        'is_special',
        'category_id',
        'ad_type_id',
        'creator_id'
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
        'ad_location' => 'string',
        'english_ad_location' => 'string',
        'advertisable_type' => 'string',
        'advertisable_id' => 'integer',
        'offered_price' => 'string',
        'phone_number' => 'string',
        'description' => 'string',
        'is_verified' => 'boolean',
        'is_special' => 'boolean',
        'category_id' => 'integer',
        'ad_type_id' => 'integer',
        'creator_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'advertisable_type' => 'required',
        'advertisable_id' => 'required',
        'offered_price' => 'required',
        'phone_number' => 'required',
        'is_verified' => 'required',
        'is_special' => 'required',
        'ad_type_id' => 'required',
        'creator_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function adType()
    {
        return $this->belongsTo(\App\Models\AdType::class, 'ad_type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'creator_id');
    }
}
