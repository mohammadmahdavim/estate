<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditionStoreRequest extends FormRequest
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
            'book_id' => 'required',
            'forecast' => 'required|date_format:Y/m/d',
            'type' => 'required|in:' . implode(",", config('global.enums.editions.types')),
        ];
    }

}
