<?php

namespace App\Repositories;

use App\Models\Media;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MediaRepository
 * @package App\Repositories
 * @version September 18, 2019, 2:29 pm UTC
 *
 * @method Media findWithoutFail($id, $columns = ['*'])
 * @method Media find($id, $columns = ['*'])
 * @method Media first($columns = ['*'])
*/
class MediaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'caption',
        'path',
        'type',
        'owner_type',
        'owner_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Media::class;
    }
}
