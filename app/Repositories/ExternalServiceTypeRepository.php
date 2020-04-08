<?php

namespace App\Repositories;

use App\Models\ExternalServiceType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExternalServiceTypeRepository
 * @package App\Repositories
 * @version April 8, 2020, 4:34 am +0430
 *
 * @method ExternalServiceType findWithoutFail($id, $columns = ['*'])
 * @method ExternalServiceType find($id, $columns = ['*'])
 * @method ExternalServiceType first($columns = ['*'])
*/
class ExternalServiceTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'version'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExternalServiceType::class;
    }
}
