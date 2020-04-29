<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'string',
            'last_name' => 'string',
            'birthday' => 'date',
            'email' => 'unique:users,email,'.$this->route('user'),
            'username' => 'unique:users,username,'.$this->route('user'),
            'scu_id' => 'unique:users,scu_id,'.$this->route('user'),
            'phone_number' => 'regex:/(09)[0-9]{9}/|size:11|unique:users,phone_number,'.$this->route('user'),
            'confirm_password' => 'same:password',
            'national_id' => 'unique:users,national_id,'.$this->route('user'),
            'avatar_path' => 'image|mimes:jpg,jpeg|max:1024',
        ];
    }
}
