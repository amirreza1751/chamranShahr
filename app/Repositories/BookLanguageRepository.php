<?php

namespace App\Repositories;

use App\Models\BookLanguage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BookLanguageRepository
 * @package App\Repositories
 * @version March 21, 2020, 3:23 am +0430
 *
 * @method BookLanguage findWithoutFail($id, $columns = ['*'])
 * @method BookLanguage find($id, $columns = ['*'])
 * @method BookLanguage first($columns = ['*'])
*/
class BookLanguageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'english_title'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BookLanguage::class;
    }
}
