<?php

namespace App\Http\Requests\API;

use App\Models\NotificationSample;
use InfyOm\Generator\Request\APIRequest;

class UpdateNotificationSampleAPIRequest extends APIRequest
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
        $rules = NotificationSample::$rules;
        
        return $rules;
    }
}
