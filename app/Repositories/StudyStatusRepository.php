<?php

namespace App\Repositories;

use App\Models\StudyStatus;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StudyStatusRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:20 am +0430
 *
 * @method StudyStatus findWithoutFail($id, $columns = ['*'])
 * @method StudyStatus find($id, $columns = ['*'])
 * @method StudyStatus first($columns = ['*'])
*/
class StudyStatusRepository extends BaseRepository
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
        return StudyStatus::class;
    }
}
