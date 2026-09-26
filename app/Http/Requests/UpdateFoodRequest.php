<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['sometimes', 'required', 'string', 'max:225'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price'       => ['sometimes', 'required', 'numeric', 'min:0'],
            'quantity'    => ['sometimes', 'required', 'integer', 'min:0'],
            'image'       => ['nullable', 'string', 'max:255'],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Tên món ăn không được để trống',
            'name.string'          => 'Tên món ăn phải là chuỗi',
            'price.numeric'        => 'Giá phải là số',
            'price.min'            => 'Giá không được âm',
            'quantity.integer'     => 'Số lượng phải là số nguyên',
            'quantity.min'         => 'Số lượng không được âm',
            'category_id.exists'   => 'Danh mục không tồn tại trong hệ thống',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Dữ liệu không hợp lệ',
            'errors'  => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY)); // HTTP 422
    }
}
