<?php

namespace App\Http\Requests;

use App\Rules\EnglishPersianAlphabet;
use App\Rules\ModelClassName;
use App\Rules\PersianAlphabet;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Notice;

class UpdateNoticeRequest extends FormRequest
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
            'title' => ['required','max:191', new EnglishPersianAlphabet()],
            'link' => 'nullable|url',
            'description' => ['required', new EnglishPersianAlphabet()],
            'path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'author' => ['nullable','max:191', new PersianAlphabet()],
            'owner_type' => ['required', new ModelClassName()],
            'owner_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return  $messages = [
            'title.required' => 'عنوان را وارد کنید',
            'title.max' => 'حداکثر طول عنوان 191 کاراکتر است',
            'link.url' => 'پیوند به درستی وارد نشده است',
            'description.required' => 'توضیحات را وارد کنید',
            'path.image' => 'تصویر به درستی وارد نشده است',
            'path.mimes' => 'فرمت های مجاز برای تصویر jpg و png هستند',
            'path.uploaded' => 'حداکثر حجم مجاز باری تصویر 2MB است',
            'author.max' => 'حداکثر طول نویسنده 191 کاراکتر است',
            'owner_type.required' => 'نوع مالک را وارد کنید',
            'owner_id.required' => 'مالک را وارد کنید',
            'owner_id.numeric' => 'مالک به درستی وارد نشده است',
        ];
    }

    public function attributes()
    {
        return [
            'owner_type' => 'نوع مالک',
            'title' => 'عنوان',
            'brief_description' => 'توضیحات',
            'author' => 'نویسنده',
        ];
    }
}
