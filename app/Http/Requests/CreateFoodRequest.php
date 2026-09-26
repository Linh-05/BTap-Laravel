<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CreateFoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:225'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price'       => ['required', 'numeric', 'min:0'],
            'quantity'    => ['required', 'integer', 'min:0'],
            'image'       => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Tên món ăn là bắt buộc',
            'name.string'          => 'Tên món ăn phải là chuỗi',
            'name.max'             => 'Tên món ăn không được vượt quá 225 ký tự',
            'description.string'   => 'Mô tả phải là chuỗi',
            'description.max'      => 'Mô tả không được vượt quá 1000 ký tự',
            'price.required'       => 'Giá món ăn là bắt buộc',
            'price.numeric'        => 'Giá phải là số',
            'price.min'            => 'Giá không được âm',
            'quantity.required'    => 'Số lượng là bắt buộc',
            'quantity.integer'     => 'Số lượng phải là số nguyên',
            'quantity.min'         => 'Số lượng không được âm',
            'image.string'         => 'Hình ảnh phải là chuỗi',
            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists'   => 'Danh mục không tồn tại trong hệ thống',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Dữ liệu không hợp lệ',
            'errors'  => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY)); 
    }
}
