<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
    /* ================= ADMIN ================= */
    if ($this->is('admin/*') && Auth::guard('admin')->check()) {

        $userId = Auth::guard('admin')->id();

        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255|unique:admins,email,' . $userId,
            'phone'   => 'nullable|string|max:255|unique:admins,phone,' . $userId,
            'address' => 'nullable|string',
            'city'    => 'nullable|string',
            'state'   => 'nullable|string',
            'zip'     => 'nullable|string',
            'country' => 'nullable|string',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /* ================= USER (WEB) ================= */
    if (Auth::guard('web')->check()) {

        $userId = Auth::guard('web')->id();

        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $userId,
            'phone'      => 'nullable|string|max:255|unique:users,phone,' . $userId,
            'address'    => 'nullable|string',
            'bio'        => 'nullable|string',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /* ================= INSTRUCTOR ================= */
    if (Auth::guard('instructor')->check()) {

        $userId = Auth::guard('instructor')->id();

        return [
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:instructors,email,' . $userId,
            'phone'      => 'nullable|string|max:255|unique:instructors,phone,' . $userId,
            'address'    => 'nullable|string',
            'city'       => 'nullable|string',
            'state'      => 'nullable|string',
            'zip'        => 'nullable|string',
            'country'    => 'nullable|string',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio'        => 'nullable|string',
            'experience' => 'nullable|string',
            'gender'     => 'nullable|in:male,female',
        ];
    }

    return [];
}


    /**
     * Optional: custom messages
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already taken.',
            'phone.unique' => 'This phone number is already taken.',
            'photo.image' => 'The photo must be an image file.',
        ];
    }
}
