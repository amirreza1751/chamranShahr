<?php

namespace App\Repositories;

use App\Models\Faculty;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FacultyRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:19 am +0430
 *
 * @method Faculty findWithoutFail($id, $columns = ['*'])
 * @method Faculty find($id, $columns = ['*'])
 * @method Faculty first($columns = ['*'])
*/
class FacultyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unique_code',
        'department_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Faculty::class;
    }
}
