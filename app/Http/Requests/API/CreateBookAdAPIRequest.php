<?php

namespace App\Http\Requests\API;

use App\Rules\EnglishPersianAlphabet;
use App\Rules\PersianAlphabet;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookAdAPIRequest extends FormRequest
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
            'title' => ['required', new PersianAlphabet(), 'max:191'],
            'book_title' => ['required', new EnglishPersianAlphabet(), 'max:191'],
            'author' => ['nullable', new EnglishPersianAlphabet(), 'max:191'],
            'category_id' => 'nullable|integer|min:0',
            'offered_price' => 'required|numeric|max:999999999999|min:0',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:512',
            'translator' => ['nullable', new EnglishPersianAlphabet(), 'max:191'],
            'publisher' => ['nullable', new EnglishPersianAlphabet(), 'max:191'],
            'price' => 'nullable|numeric|max:999999999999|min:0',
            'phone_number' => 'required|regex:/^((09)[0-9\s\-\+\(\)]{9})$/',
            'publish_month' => 'required|numeric|min:2',
            'publish_year' => 'required|numeric|min:4',
            'edition_id' => 'nullable|integer|min:0',
            'language_id' => 'nullable|integer|min:0',
            'book_length' => 'nullable|integer|min:0',
            'isbn' => ['nullable','regex:/^(\d{4}(-)\d{4}(-)\d{4}(-)\d{4})$/'],
            'is_grayscale' => 'nullable|boolean',
            'size_id' => 'nullable|integer|min:0',
            'description' => ['nullable', new EnglishPersianAlphabet()],
        ];
    }

    public function messages()
    {
        $messages = [
            'title.required' => 'عنوان آگهی را وارد کنید',
            'title.max' => 'حداكثر طول مجاز عنوان آگهی 95 كركتر است',
            'book_title.required' => 'عنوان کتاب را وارد کنید',
            'book_title.max' => 'حداكثر طول مجاز عنوان کتاب 95 كركتر است',
            'author.max' => 'حداكثر طول مجاز نویسنده 95 كركتر است',
            'category_id.*' => 'دسته را به درستی انتخاب کنید',
            'offered_price.required' => 'قیمت فروش را وارد کنید',
            'offered_price.max' => 'قیمت فروش به درستی وارد نشده است. قیمت فروش یک عدد نهایتا 12 رقمی است.',
            'images.array' => 'تصاویر به درستی ارسال نشده اند',
            'images.max' => 'حداکثر 3 تصویر مجاز است',
            'images.*.max' => 'حداکثر اندازه مجاز برای تصاویر 512 کیلوبایت است',
            'images.*.image' => 'فرمت مجاز برای تصاویر jpg و png است',
            'images.*.mimes' => 'فرمت مجاز برای تصاویر jpg و png است',
            'translator.max' => 'حداكثر طول مجاز مترجم 95 كركتر است',
            'publisher.max' => 'حداكثر طول مجاز ناشر 95 كركتر است',
            'price.digits' => 'قیمت روی جلد به درستی وارد نشده است. قیمت روی جلد یک عدد نهایتا 12 رقمی است.',
            'phone_number.regex' => 'تلفن همراه را به درستی وارد کنید (مانند 09123456789)',
            'phone_number.required' => 'تلفن همراه را وارد کنید',
            'publish_month.required' => 'ماه انتشار را وارد کنید',
            'publish_month.*' => 'ماه انتشار را به درستی انتخاب کنید. ماه انتشار یک عدد 2 رقمی است',
            'publish_year.required' => 'سال انتشار را وارد کنید',
            'publish_year.*' => 'سال انتشار را به درستی انتخاب کنید. سال انتشار یک عدد 4 رقمی است',
            'edition_id.*' => 'شماره ویرایش را به درستی انتخاب کنید',
            'language_id.*' => 'زبان را به درستی انتخاب کنید',
            'book_length.*' => 'تعداد صفحات را به درستی انتخاب کنید',
            'isbn.regex' => 'isbn را به درستی وارد کنید (مانند 1111-1111-1111-1111)',
            'is_grayscale.*' => 'رنگ را به درستی انتخاب کنید',
            'size_id.*' => 'ابعاد را به درستی انتخاب کنید',
        ];

//        foreach ($this->request->get('images') as $key => $val) {
//            $messages["images[$key].uploaded"] = "حداکثر اندازه ی مجاز برای تصاویر 512 کیلوبایت است";
//        }

        return $messages;
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان آگهی',
            'book_title' => 'عنوان کتاب',
            'author' => 'نویسنده',
            'translator' => 'مترجم',
            'publisher' => 'ناشر',
            'description' => 'توضیحات',
        ];
    }
}
