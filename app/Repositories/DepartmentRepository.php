<?php

namespace App\Repositories;

use App\Models\Department;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartmentRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:18 am +0430
 *
 * @method Department findWithoutFail($id, $columns = ['*'])
 * @method Department find($id, $columns = ['*'])
 * @method Department first($columns = ['*'])
*/
class DepartmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'english_title',
        'description',
        'path',
        'manage_level_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Department::class;
    }
}
