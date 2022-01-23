<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sectionrequest extends FormRequest
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
            'section_name'=>'required',
            'description'=>'required',
           
        ];
    }

public function messages(){
    return[
        'section_name.required'=>'برجاء ادخال اسم القسم',
        'description.required'=>'برجاء ادخال وصف القسم',
    ];
         
}




}
