<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTimeLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules():array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
        ];
    }

    public function messages()
    {
        return [
            'project_id.required' => 'Please select a project.',
            'project_id.exists' => 'The selected project is invalid.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'Invalid start time format.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'Invalid end time format.',
            'end_time.after' => 'The end time must be after the start time.',
        ];
    }
}
