<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentInstructoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       
    $id = $this->route('student'); 

    return [
        'name' => 'required|min:3|max:255',

        'student_email' => [
            'required',
            'email',
            Rule::unique('students', 'student_email')
                ->ignore($id), // ✅ تجاهل نفس الـ ID
        ],

        'password' => 'nullable|min:6|max:255',

        'course_id' => 'required|array',
        'course_id.*' => 'exists:courses,id',

        'status' => 'required|in:active,inactive',
    ];
    }
}
