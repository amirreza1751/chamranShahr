<?php

namespace App\Repositories;

use App\Models\Notice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NoticeRepository
 * @package App\Repositories
 * @version September 23, 2019, 3:45 am +0330
 *
 * @method Notice findWithoutFail($id, $columns = ['*'])
 * @method Notice find($id, $columns = ['*'])
 * @method Notice first($columns = ['*'])
*/
class NoticeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'link',
        'path',
        'description',
        'author'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notice::class;
    }
}
