<?php

namespace App\Repositories;

use App\Models\StudyLevel;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StudyLevelRepository
 * @package App\Repositories
 * @version February 7, 2020, 6:57 pm +0330
 *
 * @method StudyLevel findWithoutFail($id, $columns = ['*'])
 * @method StudyLevel find($id, $columns = ['*'])
 * @method StudyLevel first($columns = ['*'])
*/
class StudyLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'english_title',
        'unique_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StudyLevel::class;
    }
}
