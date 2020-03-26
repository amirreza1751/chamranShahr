<?php

namespace App\Repositories;

use App\Models\ManageHierarchy;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ManageHierarchyRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:17 am +0430
 *
 * @method ManageHierarchy findWithoutFail($id, $columns = ['*'])
 * @method ManageHierarchy find($id, $columns = ['*'])
 * @method ManageHierarchy first($columns = ['*'])
*/
class ManageHierarchyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'manage_type',
        'manage_id',
        'managed_by_type',
        'managed_by_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ManageHierarchy::class;
    }
}
