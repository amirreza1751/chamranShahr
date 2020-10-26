<?php

namespace App\Repositories;

use App\Models\NotificationSample;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NotificationSampleRepository
 * @package App\Repositories
 * @version October 26, 2020, 7:18 pm +0330
 *
 * @method NotificationSample findWithoutFail($id, $columns = ['*'])
 * @method NotificationSample find($id, $columns = ['*'])
 * @method NotificationSample first($columns = ['*'])
*/
class NotificationSampleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'brief_description',
        'type',
        'notifier_type',
        'notifier_id',
        'deadline'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return NotificationSample::class;
    }
}
