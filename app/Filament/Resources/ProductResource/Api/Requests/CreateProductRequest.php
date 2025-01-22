<?php

namespace App\Filament\Resources\ProductResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
			'category_id' => 'required|integer',
			'name' => 'required|string',
			'description' => 'required|string',
			'image' => 'required|string',
			'price' => 'required|numeric',
			'stock' => 'required|integer',
			'is_active' => 'required|integer',
			'is_hot' => 'required|integer',
			'is_new' => 'required|integer'
		];
    }
}
