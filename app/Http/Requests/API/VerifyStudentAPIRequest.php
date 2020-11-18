<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class VerifyStudentAPIRequest extends FormRequest
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
            'scu_id' => 'required|regex:/^[1-9][0-9]{5,6}$/|unique:users,scu_id,'.Auth::user()->id,
            'national_id' => 'required|regex:/^[0-9]{10}$/|unique:users,national_id,'.Auth::user()->id,
        ];
    }

    public function messages()
    {
        return [
            'scu_id.required' => 'شماره دانشجویی را وارد کنید',
            'scu_id.regex' => 'شماره دانشجویی معتبر نیست. شماره دانشجویی یک کد عدد 6 یا 7 رقمی است',
            'scu_id.unique' => 'شماره دانشجویی تکراری است',
            'national_id.required' => 'شماره ملی را وارد کنید',
            'national_id.regex' => 'شماره ملی معتبر نیست. شماره دانشجویی یک کد عدد 10 رقمی است',
            'national_id.unique' => 'شماره ملی تکراری است',
        ];
    }
}
