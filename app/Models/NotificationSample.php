<?php

namespace App\Models;

use App\General\Constants;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="NotificationSample",
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
class NotificationSample extends Model
{
    use SoftDeletes;

    public $table = 'notification_samples';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'brief_description',
        'type',
        'notifier_type',
        'notifier_id',
        'deadline'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'brief_description' => 'string',
        'type' => 'string',
        'notifier_type' => 'string',
        'notifier_id' => 'integer',
        'deadline' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required|string|max:191',
        'type' => ['nullable','regex:/' . '^'.Constants::EDUCATIONAL_NOTIFICATION.'$' . '|' . '^'.Constants::STUDIOUS_NOTIFICATION.'$' . '|' . '^'.Constants::COLLEGIATE_NOTIFICATION.'$' . '|' . '^'.Constants::CULTURAL_NOTIFICATION.'$/'],
        'brief_description' => 'required|string|max:191',
        'deadline' => ['required','regex:/(\d{3,4}(\/)(([0-9]|(0)[0-9])|((1)[0-2]))(\/)([0-9]|[0-2][0-9]|(3)[0-1]))$/'],
    ];

    public static $messages = [
        'title.string' => 'عنوان  به درستی وارد نشده است',
        'title.required' => 'عنوان را وارد کنید',
        'title.max' => 'حداکثر طول عنوان 191 کاراکتر است',
        'brief_description.string' => 'توضیحات به درستی وارد نشده است',
        'brief_description.required' => 'توضیحات را وارد کنید',
        'type.regex' => 'نوع نوتیفیکیشن به درستی وارد نشده است',
        'type.required' => 'نوع نوتیفیکیشن را وارد کنید',
        'deadline.required' => 'تاریخ انقضا را از طریق تقویم وارد کنید',
        'deadline.regex' => 'تاریخ انقضا به درستی وارد نشده است',
    ];

    public function getAbsolutePathAttribute(){ return $this->notifier->absolute_path; }
    public function getThumbnaiAttribute(){ return $this->notifier->thumbnail; }

    public function notifier()
    {
        return $this->morphTo();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'sample_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($notification_sample) { // cascade on soft delete for notifications
            $notification_sample->notifications()->delete();
        });

        static::restored(function($notification_sample) { // cascade on restore for notifications
            $notification_sample->notifications()->withTrashed()->restore();
        });
    }
}
