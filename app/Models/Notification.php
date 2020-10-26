<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

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


    protected $dates = ['deleted_at', 'read_at'];


    public $fillable = [
        'notifiable_type',
        'notifiable_id',
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
        'notifiable_type' => 'string',
        'notifiable_id' => 'integer',
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
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function notificationSample()
    {
        return $this->belongsTo(NotificationSample::class, 'sample_id');
    }

    public function getTitleAttribute() { return $this->notificationSample->title; }
    public function getBriefDescriptionAttribute() { return $this->notificationSample->brief_description; }
    public function getTypeAttribute() { return $this->notificationSample->type; }
    public function getNotifierTypeAttribute() { return $this->notificationSample->notifier_type; }
    public function getNotifierIdAttribute() { return $this->notificationSample->notifier_id; }
    public function getDeadlineAttribute() { return $this->notificationSample->deadline; }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'read_at',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
            ->all();
        $retrieve['title'] = $this->title;
        $retrieve['brief_description'] = $this->brief_description;
        $retrieve['type'] = $this->type;
        $retrieve['notifier_type'] = $this->notifier_type;
        $retrieve['notifier_id'] = $this->notifier_id;
        $retrieve['deadline'] = $this->deadline;
        if(isset($this->notificationSample->notifier)){
            $retrieve['thumbnail'] = $this->notificationSample->notifier->thumbnail;
            $retrieve['path'] = $this->notificationSample->notifier->absolute_path;
        }
        return $retrieve;
    }

    public static function staticRetrieves($notifications)
    {
        $retrieves = array();
        foreach ($notifications as $notification){
            $item = Notification::find($notification->id);
            if (isset($item))
                array_push($retrieves, $item->retrieve());
        }

        return $retrieves;
    }

    public static function staticRetrievesWithTrashed($notifications)
    {
        $retrieves = array();
        foreach ($notifications as $notification){
            $item = Notification::withTrashed()->find($notification->id);
            if (isset($item))
                array_push($retrieves, $item->retrieve());
        }

        return $retrieves;
    }

    public static function staticRemoveTrashed($notifications)
    {
        $result = new DatabaseNotificationCollection();
        foreach ($notifications as $notification){
            if(empty($notification->deleted_at)){
                $result->push($notification);
            }
        }

        return $result;
    }

    public static function staticRemoveUnTrashed($notifications)
    {
        $result = new DatabaseNotificationCollection();
        foreach ($notifications as $notification){
            if(isset($notification->deleted_at)){
                $result->push($notification);
            }
        }

        return $result;
    }
}
