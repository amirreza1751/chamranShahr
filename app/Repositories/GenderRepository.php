<?php

namespace App\Repositories;

use App\Models\Gender;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GenderRepository
 * @package App\Repositories
 * @version January 30, 2020, 9:59 pm +0330
 *
 * @method Gender findWithoutFail($id, $columns = ['*'])
 * @method Gender find($id, $columns = ['*'])
 * @method Gender first($columns = ['*'])
*/
class GenderRepository extends BaseRepository
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
        return Gender::class;
    }
}
