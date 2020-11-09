<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="ExternalService",
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
 *          property="url",
 *          description="url",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type_id",
 *          description="type_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="content_type",
 *          description="content_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="owner_type",
 *          description="owner_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="owner_id",
 *          description="owner_id",
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
class ExternalService extends Model
{
    use SoftDeletes;

    public $table = 'external_services';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'english_title',
        'url',
        'type_id',
        'content_type',
        'owner_type',
        'owner_id'
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
        'url' => 'string',
        'type_id' => 'integer',
        'content_type' => 'string',
        'owner_type' => 'string',
        'owner_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|max:191',
        'english_title' => 'nullable|string|max:191',
        'url' => 'required|url|max:400',
        'content_type' => 'required|string|max:32',
        'owner_type' => 'required|string',
        'owner_id' => 'required|numeric',
    ];

    public static $messages = [
        'title.required' => 'عنوان را وارد کنید',
        'title.string' => 'عنوان به درستی وارد نشده است',
        'title.max' => 'حداکثر طول عنوان 191 کاراکتر است',
        'english_title.string' => 'عنوان انگلیسی به درستی وارد نشده است',
        'english_title.max' => 'حداکثر طول عنوان انگلیسی 191 کاراکتر است',
        'url.required' => 'آدرس را وارد کنید',
        'url.url' => 'آدرس به درستی وارد نشده است',
        'url.max' => 'حداکثر طول آدرس 400 کاراکتر است',
        'content_type.required' => 'نوع محتوا را وارد کنید',
        'content_type.string' => 'نوع محتوا به درستی وارد نشده است',
        'content_type.max' => 'حداکثر طول نوع محتوا 32 کاراکتر است',
        'owner_type.required' => 'نوع مالک را انتخاب کنید',
        'owner_type.string' => 'نوع مالک به درستی انتخاب نشده است',
        'owner_id.required' => 'مالک را انتخاب کنید',
        'owner_id.numeric' => 'مالک به درستی انتخاب نشده است',
        'type_id.required' => 'نوع را انتخاب کنید',
        'type_id.numeric' => 'نوع به درستی انتخاب نشده است',
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(ExternalServiceType::class);
    }

}
