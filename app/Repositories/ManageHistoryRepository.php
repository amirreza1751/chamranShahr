<?php

namespace App\Repositories;

use App\Models\ManageHistory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ManageHistoryRepository
 * @package App\Repositories
 * @version March 25, 2020, 10:43 am +0430
 *
 * @method ManageHistory findWithoutFail($id, $columns = ['*'])
 * @method ManageHistory find($id, $columns = ['*'])
 * @method ManageHistory first($columns = ['*'])
*/
class ManageHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'manager_id',
        'managed_type',
        'managed_id',
        'begin_date',
        'end_date',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ManageHistory::class;
    }
}
