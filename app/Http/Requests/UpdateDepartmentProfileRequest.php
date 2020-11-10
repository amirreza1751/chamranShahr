<?php

namespace App\Http\Requests;

use App\Rules\EnglishAlphabet;
use App\Rules\EnglishPersianAlphabet;
use App\Rules\PersianAlphabet;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentProfileRequest extends FormRequest
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
        return $rules = [
            'title' => ['nullable', new PersianAlphabet() ,'max:191'],
            'english_title' => ['nullable', new EnglishAlphabet() ,'max:191'],
            'description' => ['nullable', new EnglishPersianAlphabet(),'max:191'],
            'path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return $messages = [
            'title.max' => 'حداکثر طول عنوان 95 کاراکتر است',
            'english_title.max' => 'حداکثر طول عنوان انگلیسی 191 کاراکتر است',
            'description.max' => 'حداکثر طول توضیحات 95 کاراکتر است',
            'path.image' => 'تصویر به درستی وارد نشده است',
            'path.mimes' => 'فرمت های مجاز برای تصویر jpg و png هستند',
            'path.uploaded' => 'حداکثر حجم مجاز باری تصویر 2MB است',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان',
            'english_title' => 'عنوان انگلیسی',
            'brief_description' => 'توضیحات',
        ];
    }
}
