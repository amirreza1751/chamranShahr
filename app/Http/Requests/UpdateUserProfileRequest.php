<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserProfileRequest extends FormRequest
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
            'email' => 'nullable|email|unique:users,email,'.Auth::user()->id,
            'username' => 'nullable|regex:/^(?![.])(?!.*[.]{2})[a-zA-Z0-9.]+(?<![.])$/|min:6|max:21|unique:users,username,'.Auth::user()->id, // regex length : (?=.{6,21}$)
            'password' => 'nullable|regex:/^(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/|min:8|max:191', // regex min length : .{8} at the end
            'confirm_password' => 'same:password',
            'scu_id' => 'nullable|unique:users,scu_id,'.Auth::user()->id,
            'phone_number' => 'nullable|regex:/(09)[0-9]{9}/|size:11|unique:users,phone_number,'.Auth::user()->id,
            'national_id' => 'nullable|unique:users,national_id,'.Auth::user()->id,
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
            'email.unique' => 'پست الکترونیک تکراری است',
            'email.email' => 'پست الکترونیک معتبر نیست',
            'username.min' => 'حداقل طول نام کاربری 6 کرکتر است',
            'username.max' => 'حداکثر طول نام کاربری 21 کرکتر است',
            'username.regex' => 'نام کاربری مجاز نیست. تنها کرکتر ها و اعداد انگلیسی و "." میان عبارت مجاز است',
            'username.unique' => 'نام کاربری تکراری است',
            'password.min' => 'حداقل طول رمز عبور 8 کارکتر است',
            'password.max' => 'رمز عبور طولانی است',
            'password.regex' => 'رمز عبور مجاز نیست. رمز عبور میبایست شامل حداقل یک حرف کوچک، یک حرف بزرگ، یک عدد و یک کرکتر خاص باشد.',
            'phone_number.regex' => 'شماره همراه به درستي وارد نشده است',
            'phone_number.size' => 'طول 11 رقمي شماره تلفن همراه رعايت نشده است',
            'phone_number.unique' => 'حسابی با این شماره وجود دارد',
            'confirm_password.same' => 'رمز عبور هاي وارد شده مطابقت ندارند',
            'avatar_path.image' => 'فایل تصویر مجاز نیست',
            'avatar_path.mimes' => 'فرمت هاي مجاز براي تصوير پروفايل jpg و png مي‌باشند',
            'avatar_path.uploaded' => 'حداکثر اندازه‌ی تصویر باید 1MB باشد',
        ];
    }
}
