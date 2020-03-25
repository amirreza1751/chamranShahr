<?php

namespace App\Repositories;

use App\Models\ManageLevel;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ManageLevelRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:10 am +0430
 *
 * @method ManageLevel findWithoutFail($id, $columns = ['*'])
 * @method ManageLevel find($id, $columns = ['*'])
 * @method ManageLevel first($columns = ['*'])
*/
class ManageLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'management_title',
        'english_management_title',
        'manager_title',
        'english_manager_title',
        'level'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ManageLevel::class;
    }
}
