<?php

namespace App\Repositories;

use App\Models\StudyArea;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StudyAreaRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:20 am +0430
 *
 * @method StudyArea findWithoutFail($id, $columns = ['*'])
 * @method StudyArea find($id, $columns = ['*'])
 * @method StudyArea first($columns = ['*'])
*/
class StudyAreaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'english_title',
        'unique_code',
        'is_active',
        'study_level_unique_code',
        'study_field_unique_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StudyArea::class;
    }
}
