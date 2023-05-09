<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CreateAdvertisementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        if(!Auth::user())
//            return false;
//        return true;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'=> 'required|max:255|min:3|string',
            'price' => 'required|numeric',
            'isNegotiable' => 'required|boolean', # 0 - false, 1 - true
            'description' =>'string', # description can be empty
            'category_id' => 'integer', # default category should be general
            'state_id' => 'integer', # default should be set to user's state
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => array_values($validator->errors()->getMessages())[0][0],
        ]));
    }
}
