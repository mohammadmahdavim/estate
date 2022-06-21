<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PosterCreateRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type_id' => 'required',
            'title' => 'required',
            'form_id' => 'required',
            'lng' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'mobile' => 'required',
        ];
    }
}
