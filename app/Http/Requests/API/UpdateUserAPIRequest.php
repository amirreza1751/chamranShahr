<?php

namespace App\Http\Requests\API;

use App\User;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'unique:users,email,'.$this->user()->id,
            'username' => 'unique:users,username,'.$this->user()->id,
            'scu_id' => 'unique:users,scu_id,'.$this->user()->id,
            'phone_number' => 'required|regex:/(09)[0-9]{9}/|size:11|unique:users,phone_number,'.$this->user()->id,
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'national_id' => 'unique:users,national_id,'.$this->user()->id,
        ];
    }
}
