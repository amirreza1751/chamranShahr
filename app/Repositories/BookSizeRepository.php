<?php

namespace App\Repositories;

use App\Models\BookSize;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BookSizeRepository
 * @package App\Repositories
 * @version March 21, 2020, 3:23 am +0430
 *
 * @method BookSize findWithoutFail($id, $columns = ['*'])
 * @method BookSize find($id, $columns = ['*'])
 * @method BookSize first($columns = ['*'])
*/
class BookSizeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'size_name',
        'english_size_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BookSize::class;
    }
}
