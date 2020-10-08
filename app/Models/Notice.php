<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

/**
 * @SWG\Definition(
 *      definition="Notice",
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
 *          property="link",
 *          description="link",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="path",
 *          description="path",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="author",
 *          description="author",
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
class Notice extends Model
{
    use SoftDeletes;

    public $table = 'notices';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'link',
        'path',
        'description',
        'author',
        'owner_type',
        'owner_id',
        'creator_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'link' => 'string',
        'path' => 'string',
        'description' => 'string',
        'author' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'owner_type' => 'required',
        'owner_id' => 'required',
    ];

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifier');
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function getTitleOwnerAttribute()
    {
        return "{$this->owner->title} : {$this->title}";
    }

    public function getAbsolutePathAttribute()
    {
        return URL::to('/') . $this->path;
    }

    public function getThumbnailAttribute()
    {
        return URL::to('/') . pathinfo($this->path, PATHINFO_DIRNAME) . '/' . pathinfo(basename($this->path), PATHINFO_FILENAME) . '-thumbnail.' . pathinfo(basename($this->path), PATHINFO_EXTENSION);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'title',
                'link',
                'description',
                'owner_type',
                'owner_id',
                'created_at',
                'updated_at',
            ])
            ->all();
        $retrieve['thumbnail'] = $this->thumbnail;
        $retrieve['path'] = $this->absolute_path;
        if(isset($this->creator)){
            $retrieve['creator'] = $this->creator->full_name;
        }
        return $retrieve;
    }

    public static function staticRetrieves($notices)
    {
        $retrieves = collect();
        foreach ($notices as $notice){
            $item = Notice::find($notice->id);
            if (isset($item))
                $retrieves->push($item->retrieve());
        }

        return $retrieves;
    }
}
