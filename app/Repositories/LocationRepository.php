<?php

namespace App\Repositories;

use App\Models\Location;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LocationRepository
 * @package App\Repositories
 * @version September 18, 2019, 2:28 pm UTC
 *
 * @method Location findWithoutFail($id, $columns = ['*'])
 * @method Location find($id, $columns = ['*'])
 * @method Location first($columns = ['*'])
*/
class LocationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'x',
        'y',
        'title',
        'brief_description',
        'owner_type',
        'owner_id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Location::class;
    }
}
