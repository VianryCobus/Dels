<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardtrainingRequest extends FormRequest
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
            'start_date' => 'required',
            'end_date' => 'required',
            'trainer_name' => 'required',
            'employee' => 'required',
            'lesson' => 'max:20480|mimes:jpeg,bmp,png,jpg|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
            'task' => 'max:20480|mimes:jpeg,bmp,png,jpg|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
            'return_task' => 'max:20480|mimes:jpeg,bmp,png,jpg|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4'
        ];
    }
}
