<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

/**
 * @SWG\Definition(
 *      definition="News",
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
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="path",
 *          description="path",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="field_for_test",
 *          description="field_for_test",
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
class News extends Model
{
    use SoftDeletes;

    public $table = 'news';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'link',
        'description',
        'path',
        'field_for_test',
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
        'description' => 'string',
        'path' => 'string',
        'field_for_test' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function notifications()
    {
        return $this->morphMany(NotificationSample::class, 'notifier');
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function getTitleOwnerAttribute()
    {
        return "{$this->owner->title} : {$this->title}";
    }

    /**
     * **** ATTENTION ****
     * if there is no image on public/storage/news_images/news_default_image.jpg then you must put a default image there with same name,
     * if not, some functionality may doesn't work properly
     *
     * return default image path for news which has no image yet
     *
     * @return string path of default image
     *
     */
    public function getAbsolutePathAttribute()
    {
        $file =  new \Illuminate\Filesystem\Filesystem();

        if (isset($this->path) && $file->exists(base_path() . str_replace('storage', 'public/storage', $this->path)))
            return URL::to('/') . $this->path;
        else
            return URL::to('/') . env('DEFAULT_NEWS');
    }

    /**
     * **** ATTENTION ****
     * if there is no image on public/storage/news_images/news_default_image-thumbnail.jpg then you must put a default thumbnail image there with same name,
     * if not, some functionality may doesn't work properly
     *
     * return default thumbnail image path for news which has no thumbnail image yet
     *
     * @return string path of default thumbnail image
     *
     */
    public function getThumbnailAttribute()
    {
        $file =  new \Illuminate\Filesystem\Filesystem();

        if (isset($this->path) && $file->exists(base_path() . str_replace('storage', 'public/storage',
                    pathinfo($this->path, PATHINFO_DIRNAME) . '/' . pathinfo(basename($this->path), PATHINFO_FILENAME) . '-thumbnail.' . pathinfo(basename($this->path), PATHINFO_EXTENSION))))
            return URL::to('/') . pathinfo($this->path, PATHINFO_DIRNAME) . '/' . pathinfo(basename($this->path), PATHINFO_FILENAME) . '-thumbnail.' . pathinfo(basename($this->path), PATHINFO_EXTENSION);
        else
            return URL::to('/') . env('DEFAULT_NEWS_THUMBNAIL');
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

    public static function staticRetrieves($news)
    {
        $retrieves = collect();
        foreach ($news as $single_news){
            $item = News::find($single_news->id);
            if (isset($item))
                $retrieves->push($item->retrieve());
        }

        return $retrieves;
    }
}
