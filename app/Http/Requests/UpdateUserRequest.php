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
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'birthday' => 'nullable|date',
            'email' => 'nullable|unique:users,email,'.$this->route('user'),
            'username' => 'nullable|unique:users,username,'.$this->route('user'),
            'scu_id' => 'nullable|unique:users,scu_id,'.$this->route('user'),
            'phone_number' => 'nullable|regex:/(09)[0-9]{9}/|size:11|unique:users,phone_number,'.$this->route('user'),
            'confirm_password' => 'same:password',
            'national_id' => 'nullable|unique:users,national_id,'.$this->route('user'),
            'avatar_path' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'first_name.string' => 'نام به درستی وارد نشده است',
            'first_name.max' => 'حداكثر طول مجاز نام 50 كركتر است',
            'last_name.string' => 'نام‌خانوادگي به درستی وارد نشده است',
            'last_name.max' => 'حداكثر طول مجاز نام‌خانوادگي 50 كركتر است',
//            'email.unique' => 'پست الکترونیک تکراری است',
            'phone_number.regex' => 'شماره همراه به درستي وارد نشده است',
            'phone_number.size' => 'طول 11 رقمي شماره تلفن همراه رعايت نشده است',
            'phone_number.unique' => 'حسابی با این شماره وجود دارد',
            'confirm_password.same' => 'رمز عبور هاي وارد شده مطابقت ندارند',
            'path' => 'فرمت هاي مجاز براي تصوير پروفايل jpg و png مي‌باشند',
        ];
    }
}
