<?php

namespace App\Http\Requests\API;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class LoginFormRequest extends FormRequest
{   
     use ApiResponse;
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
    public function rules(Request $request)
    {
        if(!empty($request->email) && !empty($request->password) ){

           return [
                'email' => 'required |email',
                'password' => 'required | min:6',
            ]; 
        }else{
            return [
                'code' => 'required',
                'email' => 'required |email',
            ]; 
        }


       
           
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error($validator->errors()->first(), JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
