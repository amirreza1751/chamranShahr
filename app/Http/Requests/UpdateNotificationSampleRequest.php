<?php

namespace App\Http\Requests;

use App\General\Constants;
use App\Rules\EnglishPersianAlphabet;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\NotificationSample;

class UpdateNotificationSampleRequest extends FormRequest
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
//        $rules = NotificationSample::$rules;

        return [
            'title' => ['required', new EnglishPersianAlphabet(),'max:191'],
            'type' => ['required','regex:/' . '^'.Constants::EDUCATIONAL_NOTIFICATION.'$' . '|' . '^'.Constants::STUDIOUS_NOTIFICATION.'$' . '|' . '^'.Constants::COLLEGIATE_NOTIFICATION.'$' . '|' . '^'.Constants::CULTURAL_NOTIFICATION.'$/'],
            'brief_description' => ['required', new EnglishPersianAlphabet(),'max:191'],
            'deadline' => ['required','regex:/(\d{3,4}(\/)(([0-9]|(0)[0-9])|((1)[0-2]))(\/)([0-9]|[0-2][0-9]|(3)[0-1]))$/'],
        ];
    }

    public function messages()
    {
//        $messages = NotificationSample::$messages;

        return $messages = [
            'title.required' => 'عنوان را وارد کنید',
            'title.max' => 'حداکثر طول عنوان 191 کاراکتر است',
            'brief_description.required' => 'توضیحات را وارد کنید',
            'type.regex' => 'نوع نوتیفیکیشن به درستی وارد نشده است',
            'type.required' => 'نوع نوتیفیکیشن را وارد کنید',
            'deadline.required' => 'تاریخ انقضا را از طریق تقویم وارد کنید',
            'deadline.regex' => 'تاریخ انقضا به درستی وارد نشده است',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان',
            'brief_description' => 'توضیحات',
        ];
    }
}
