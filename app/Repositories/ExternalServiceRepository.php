<?php

namespace App\Repositories;

use App\Models\ExternalService;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExternalServiceRepository
 * @package App\Repositories
 * @version April 8, 2020, 4:36 am +0430
 *
 * @method ExternalService findWithoutFail($id, $columns = ['*'])
 * @method ExternalService find($id, $columns = ['*'])
 * @method ExternalService first($columns = ['*'])
*/
class ExternalServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'english_title',
        'url',
        'type_id',
        'content_type',
        'owner_type',
        'owner_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExternalService::class;
    }
}
