<?php

namespace App\Repositories;

use App\Models\Term;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TermRepository
 * @package App\Repositories
 * @version February 7, 2020, 2:20 am +0330
 *
 * @method Term findWithoutFail($id, $columns = ['*'])
 * @method Term find($id, $columns = ['*'])
 * @method Term first($columns = ['*'])
*/
class TermRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'unique_code',
        'term_code',
        'begin_date',
        'end_date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Term::class;
    }
}
