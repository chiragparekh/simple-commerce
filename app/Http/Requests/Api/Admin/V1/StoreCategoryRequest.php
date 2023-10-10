<?php

namespace App\Http\Requests\Api\Admin\V1;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return
            $this->user()
            && $this->user()->hasRole(Role::ADMIN->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'max:255', 'string'],
            'image' => [
                'nullable',
                File::image()
                    ->types([
                        'image/png',
                        'image/jpeg',
                    ])
                    ->max('2mb')
            ]
        ];
    }
}
