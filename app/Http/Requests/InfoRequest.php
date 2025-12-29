<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest
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
            
            case 'PUT':
            case 'PATCH':
                return [
                  'title' => 'required',
 'icon' => [
            'required',
            'string',
            'regex:/<svg[^>]*>.*<\/svg>/is', // التحقق من وجود وسم SVG
        ],      
          'description' => 'required|string',
                ];
            default:
                return [];
        }
    }
}
