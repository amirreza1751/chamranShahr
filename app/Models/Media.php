<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

/**
 * @SWG\Definition(
 *      definition="Media",
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
 *          property="caption",
 *          description="caption",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="path",
 *          description="path",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="integer",
 *          format="int32"
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
class Media extends Model
{
    use SoftDeletes;

    public $table = 'medias';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'caption',
        'path',
        'type',
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
        'caption' => 'string',
        'path' => 'string',
        'type' => 'integer',
        'owner_type' => 'string',
        'owner_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'owner_type' => 'required',
        'owner_id' => 'required'
    ];

    public function owner()
    {
        return $this->morphTo();
    }

    public function getAbsolutePathAttribute()
    {
        return URL::to('/') . $this->path;
    }

    public function retrieve(){
        $retrieve = collect($this->toArray())
            ->only([
                'id',
                'title',
                'caption',
                'type',
                'owner_type',
                'owner_id'
            ])
            ->all();
        $retrieve['path'] = $this->absolute_path;

        return $retrieve;
    }

    public static function staticRetrieves($medias)
    {
        $retrieves = collect();
        foreach ($medias as $media){
            $item = Media::find($media->id);
            if (isset($item))
                $retrieves->push($item->retrieve());
        }

        return $retrieves;
    }

}
