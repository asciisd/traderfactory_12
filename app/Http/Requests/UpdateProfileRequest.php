<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,'.$this->user()->id,
            'email' => 'required|email|max:255|unique:users,email,'.$this->user()->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }
}