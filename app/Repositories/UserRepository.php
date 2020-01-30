<?php

namespace App\Repositories;

use App\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NewsRepository
 * @package App\Repositories
 * @version September 20, 2019, 4:31 pm +0430
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'scu_id',
        'phone_number',
        'national_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
