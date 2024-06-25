<?php

namespace Modules\Item\App\Http\Requests\Admin\Item;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        $supportedLocales = core()->getSupportedLanguagesKeys();
        $rules = [];

        foreach ($supportedLocales as $locale) {
            $rules[$locale . '.name']   = ['required', 'string', 'max:255'];
            $rules[$locale . '.short_description']   = ['required', 'string'];
            $rules[$locale . '.description']   = ['required', 'string'];
        }
        $rules = [
            'code' => ['required', 'string', 'max:255', 'unique:items,code'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'rank' => ['nullable', 'integer', 'min:0'],
        ];

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'message' => 'Validation Error',
            'statusCode'=>422
        ], 422));
    }
}
