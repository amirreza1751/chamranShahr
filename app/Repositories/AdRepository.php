<?php

namespace App\Repositories;

use App\Models\Ad;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AdRepository
 * @package App\Repositories
 * @version March 21, 2020, 3:20 am +0430
 *
 * @method Ad findWithoutFail($id, $columns = ['*'])
 * @method Ad find($id, $columns = ['*'])
 * @method Ad first($columns = ['*'])
*/
class AdRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'english_title',
        'ad_location',
        'english_ad_location',
        'advertisable_type',
        'advertisable_id',
        'offered_price',
        'phone_number',
        'description',
        'is_verified',
        'is_special',
        'category_id',
        'ad_type_id',
        'creator_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ad::class;
    }
}
