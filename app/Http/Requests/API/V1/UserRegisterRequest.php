<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            'first_name'        => 'required|string|max:50',
            'last_name'         => 'required|string|max:50',
            'email'             => 'required|email|unique:users',
            'password'          => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'           => 'First name is required',
            'first_name.string'             => 'First name must only contain letters',
            'first_name.max'                => 'First name must be less than 50 characters',
            'last_name.required'            => 'Last name is required',
            'last_name.string'              => 'Last name must only contain letters',
            'last_name.max'                 => 'Last name must be less than 50 characters',
            'email.required'                => 'Email is required',
            'email.email'                   => 'Email is invalid',
            'email.unique'                  => 'Email is already in use',
            'password.required'             => 'Password is required',
            'password.min'                  => 'Password must be at least 8 characters',
            'password.confirmed'            => 'Password confirmation does not match',
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
