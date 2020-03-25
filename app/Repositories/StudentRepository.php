<?php

namespace App\Repositories;

use App\Models\Student;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StudentRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:21 am +0430
 *
 * @method Student findWithoutFail($id, $columns = ['*'])
 * @method Student find($id, $columns = ['*'])
 * @method Student first($columns = ['*'])
*/
class StudentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'study_area_unique_code',
        'study_level_unique_code',
        'entrance_term_unique_code',
        'study_status_unique_code',
        'total_average',
        'is_active',
        'is_guest',
        'is_iranian',
        'in_dormitory'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Student::class;
    }
}
