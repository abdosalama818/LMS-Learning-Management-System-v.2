<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
          switch($this->method()){
            case 'POST':
                return [
                    'title' => 'required|unique:sliders,title',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'short_description' => 'required|string',
                    'video_url' => 'required|string',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => 'required|unique:sliders,title,'.$this->route('slider'),
                     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'short_description' => 'required|string',
                    'video_url' => 'required|string',
                ];
            default:
                return [];
        }
    }
}
