<?php

namespace App\Http\Requests;

use App\General\Constants;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Notice;
use App\Models\StudyArea;
use App\Models\StudyField;
use App\Models\StudyLevel;
use App\Models\StudyStatus;
use App\Models\Term;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Console\Output\ConsoleOutput;

class NotifyRequest extends FormRequest
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
        $console = new ConsoleOutput();
        $console->writeln(Notice::class);
        return [
            'notifier_type' => ['required','string'],
            'notifier_id' => 'required|numeric',
            'title' => 'required_if:use_notifier_title,==,""|max:191',
            'brief_description' => 'required_if:use_notifier_description,==,""',
            'deadline' => ['required','regex:/(\d{3,4}(\/)(([0-9]|(0)[0-9])|((1)[0-2]))(\/)([0-9]|[0-2][0-9]|(3)[0-1]))$/'],
            'study_status_unique_code' => ['nullable','regex:/^' . strtolower(array_last(explode("\\", StudyStatus::class))) . '[0-9]+$/'],
            'faculty_unique_code' => ['nullable','regex:/^' . strtolower(array_last(explode("\\", Faculty::class))) . '[0-9]+$/'],
            'study_field_unique_code' => ['nullable','regex:/^' . strtolower(array_last(explode("\\", StudyField::class))) . '[0-9]+$/'],
            'study_level_unique_code' => ['nullable','regex:/^' . strtolower(array_last(explode("\\", StudyLevel::class))) . '[0-9]+$/'],
            'study_area_unique_code' => ['nullable','regex:/^' . strtolower(array_last(explode("\\", StudyArea::class))) . '[0-9]+$/'],
            'entrance_term_unique_code' => ['nullable','regex:/^' . strtolower(array_last(explode("\\", Term::class))) . '[0-9]+$/'],
            'type' => ['required','regex:/' . '^'.Constants::EDUCATIONAL_NOTIFICATION.'$' . '|' . '^'.Constants::STUDIOUS_NOTIFICATION.'$' . '|' . '^'.Constants::COLLEGIATE_NOTIFICATION.'$' . '|' . '^'.Constants::CULTURAL_NOTIFICATION.'$/'],
            'user_type' => ['nullable','regex:/' . '^'.Constants::ALL_USERS.'$' . '|' . '^'.Constants::STUDENTS.'$' . '|' . '^'.Constants::EMPLOYEES.'$' . '|' . '^'.Constants::PROFESSORS.'$/']
        ];
    }
    public function messages()
    {
        return [
            'notifier_type.required' => 'نوع منبع را انتخاب کنید',
            'notifier_type.regex' => 'نوع منبع به درستی وارد نشده است',
            'notifier_id.required' => 'منبع را انتخاب کنید',
            'notifier_id.numeric' => 'منبع به درستی وارد نشده است',
            'title.string' => 'عنوان  به درستی وارد نشده است',
            'title.required_if' => 'عنوان را وارد کنید',
            'brief_description.required_if' => 'توضیحات را وارد کنید',
            'brief_description.string' => 'توضیحات به درستی وارد نشده است',
            'deadline.required' => 'تاریخ انقضا را از طریق تقویم وارد کنید',
            'deadline.regex' => 'تاریخ انقضا به درستی وارد نشده است',
            'faculty_unique_code.regex' => 'دانشکده به درستی وارد نشده است',
            'study_field_unique_code.regex' => 'رشته به درستی وارد نشده است',
            'study_level_unique_code.regex' => 'مقطع به درستی وارد نشده است',
            'study_area_unique_code.regex' => 'گرایش به درستی وارد نشده است',
            'study_status_unique_code.regex' => 'وضعیت تحصیلی به درستی وارد نشده است',
            'entrance_term_unique_code.regex' => 'ورودی به درستی وارد نشده است',
            'type.regex' => 'نوع نوتیفیکیشن به درستی وارد نشده است',
            'type.required' => 'نوع نوتیفیکیشن را وارد کنید',
            'user_type.regex' => 'نوع کاربری به درستی وارد نشده است',
        ];
    }
}
