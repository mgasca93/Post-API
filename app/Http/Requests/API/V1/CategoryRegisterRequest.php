<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRegisterRequest extends FormRequest
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
            'name'      => 'required|min:5|string|unique:categories'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Category name is required',
            'name.min'              => 'Category name must be less than 5 characters',
            'name.string'           => 'Category name must be a string',
            'name.unique'           => 'Category must be unique',
        ];
    }

    protected function failedValidation( Validator $validator )
    {
        throw new HttpResponseException(
            response()->json([
                'status'    => 'failed',
                'message'   => 'Validation failed',
                'errors'    => $validator->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
