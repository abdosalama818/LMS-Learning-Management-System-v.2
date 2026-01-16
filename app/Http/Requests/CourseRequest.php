<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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

        return [

            'course_name' => [
            'required',
            'string',
            'max:255',
           Rule::unique('courses', 'course_name')
    ->where(fn ($q) => $q->where('instructor_id', auth('instructor')->id()))
    ->ignore($this->route('course')?->id),
        ],
            'course_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'course_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'resources' => 'nullable|integer|min:0',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'label' => 'nullable|in:beginer,medium,advance',
            'certificate' => 'nullable|in:yes,no',
            'selling_price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:selling_price',
            'duration' => 'nullable|numeric|min:0',
            'prerequisites' => 'nullable|string',
            'course_goals' => 'nullable|array',
            'course_goals.*' => 'nullable|string|max:255',
            'bestseller' => 'nullable|in:yes,no',
            'featured' => 'nullable|in:yes,no',
            'highestrated' => 'nullable|in:yes,no',
        ];
    }
}

