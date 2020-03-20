<?php

namespace App\Repositories;

use App\Models\AdType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AdTypeRepository
 * @package App\Repositories
 * @version March 21, 2020, 3:17 am +0430
 *
 * @method AdType findWithoutFail($id, $columns = ['*'])
 * @method AdType find($id, $columns = ['*'])
 * @method AdType first($columns = ['*'])
*/
class AdTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ad_type_title',
        'english_ad_type_title'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AdType::class;
    }
}
