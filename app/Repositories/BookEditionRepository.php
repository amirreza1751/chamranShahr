<?php

namespace App\Repositories;

use App\Models\BookEdition;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BookEditionRepository
 * @package App\Repositories
 * @version March 21, 2020, 3:22 am +0430
 *
 * @method BookEdition findWithoutFail($id, $columns = ['*'])
 * @method BookEdition find($id, $columns = ['*'])
 * @method BookEdition first($columns = ['*'])
*/
class BookEditionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'edition',
        'english_edition'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BookEdition::class;
    }
}
