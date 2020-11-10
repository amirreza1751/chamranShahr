<?php

namespace App\Http\Requests;

use App\Rules\EnglishAlphabet;
use App\Rules\EnglishPersianAlphabet;
use App\Rules\ModelClassName;
use App\Rules\PersianAlphabet;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\ExternalService;

class UpdateExternalServiceRequest extends FormRequest
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
//        return ExternalService::$rules;'
        return $rules = [
            'title' => ['required', new EnglishPersianAlphabet(),'max:191'],
            'english_title' => ['required', new EnglishAlphabet(),'max:191'],
            'url' => 'required|url|max:400',
            'content_type' => ['required', new ModelClassName(),'max:32'],
            'owner_type' => ['required', new ModelClassName(),'max:32'],
            'owner_id' => 'required|numeric',
            'type_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
//        return ExternalService::$messages;
        return $messages = [
            'title.required' => 'عنوان را وارد کنید',
            'title.max' => 'حداکثر طول عنوان 191 کاراکتر است',
            'english_title.max' => 'حداکثر طول عنوان انگلیسی 191 کاراکتر است',
            'url.required' => 'آدرس را وارد کنید',
            'url.url' => 'آدرس به درستی وارد نشده است',
            'url.max' => 'حداکثر طول آدرس 400 کاراکتر است',
            'content_type.required' => 'نوع محتوا را وارد کنید',
            'content_type.max' => 'حداکثر طول نوع محتوا 32 کاراکتر است',
            'owner_type.required' => 'نوع مالک را انتخاب کنید',
            'owner_id.required' => 'مالک را انتخاب کنید',
            'owner_id.numeric' => 'مالک به درستی انتخاب نشده است',
            'type_id.required' => 'نوع را انتخاب کنید',
            'type_id.numeric' => 'نوع به درستی انتخاب نشده است',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان',
            'english_title' => 'عنوان انگلیسی',
            'content_type' => 'نوع محتوا',
            'owner_type' => 'نوع مالک',
        ];
    }
}
