<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPhoneNumberRequest extends FormRequest
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
            'phone_number' => 'required|regex:/^((09)[0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'otp_code' => 'required|regex:/^([0-9]{5})$/'
        ];
    }

    public function messages()
    {
        return [
            'phone_number.required' => 'شماره تلفن همراه را وارد کنید',
            'phone_number.regex' => 'شماره تلفن همراه را به درستی وارد کنید (مانند: 09123456789)',
            'phone_number.min' => 'شماره تلفن همراه باید 11 رقم باشد',
            'phone_number.max' => 'شماره تلفن همراه باید 11 رقم باشد',
            'otp_code.required' => 'کد 5 رقمی را وارد کنید',
            'otp_code.regex' => 'کد 5 رقمی به درستی وارد نشده است (مانند: 1 1 1 1 1)',
        ];
    }
}
