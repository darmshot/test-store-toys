<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CatalogProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id           = \Request::get('id');
        $price        = \Request::get('price');
        $priceSpecial = \Request::get('price_special');

        return [
            // 'name' => 'required|min:5|max:255'
            'title'         => 'required|min:2|max:60',
            'sku'           => 'required|min:2|max:60',
            'slug'          => 'unique:catalog_products,slug' . ($id ? ',' . $id : '') . '|unique:aliases,model_id' . ($id ? ',' . $id : ''),
            'price'         => ($price) ? 'regex:/^\d{1,15}(\.\d{1,2})?$/' : '',
            'price_special' => ($priceSpecial) ? 'regex:/^\d{1,15}(\.\d{1,2})?$/' : ''
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
