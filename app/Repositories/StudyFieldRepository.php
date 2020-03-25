<?php

namespace App\Repositories;

use App\Models\StudyField;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StudyFieldRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:20 am +0430
 *
 * @method StudyField findWithoutFail($id, $columns = ['*'])
 * @method StudyField find($id, $columns = ['*'])
 * @method StudyField first($columns = ['*'])
*/
class StudyFieldRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unique_code',
        'faculty_unique_code',
        'department_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StudyField::class;
    }
}
