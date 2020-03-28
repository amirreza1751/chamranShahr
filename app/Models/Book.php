<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Book",
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
 *          property="edition_id",
 *          description="edition_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="publisher",
 *          description="publisher",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="publication_date",
 *          description="publication_date",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="book_length",
 *          description="book_length",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="language_id",
 *          description="language_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="isbn",
 *          description="isbn",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="author",
 *          description="author",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="translator",
 *          description="translator",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="price",
 *          description="price",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="size_id",
 *          description="size_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="is_grayscale",
 *          description="is_grayscale",
 *          type="boolean"
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
class Book extends Model
{
    use SoftDeletes;

    public $table = 'books';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'edition_id',
        'publisher',
        'publication_date',
        'book_length',
        'language_id',
        'isbn',
        'author',
        'translator',
        'price',
        'size_id',
        'is_grayscale'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'edition_id' => 'integer',
        'publisher' => 'string',
        'publication_date' => 'datetime',
        'book_length' => 'integer',
        'language_id' => 'integer',
        'isbn' => 'string',
        'author' => 'string',
        'translator' => 'string',
        'price' => 'string',
        'size_id' => 'integer',
        'is_grayscale' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'edition_id' => 'required',
        'publisher' => 'required',
        'publication_date' => 'required',
        'book_length' => 'required',
        'language_id' => 'required',
        'isbn' => 'required',
        'author' => 'required',
        'translator' => 'required',
        'price' => 'required',
        'size_id' => 'required',
        'is_grayscale' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function edition()
    {
        return $this->belongsTo(\App\Models\BookEdition::class, 'edition_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function language()
    {
        return $this->belongsTo(\App\Models\BookLanguage::class, 'language_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function size()
    {
        return $this->belongsTo(\App\Models\BookSize::class, 'size_id');
    }


    public function ad(){
        return $this->morphOne('App\Models\Ad', 'advertisable');
    }
}
