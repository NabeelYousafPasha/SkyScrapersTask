<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BloggerRequest extends FormRequest
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
        $blogger = $this->route('blogger');
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:admins|unique:users|unique:bloggers',
                        'password' => 'required|min:8||max:255|confirmed',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:users|unique:admins|unique:bloggers,email,'.$blogger->id.',id',
                    ];
                }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'name' => 'Name of Blogger',
            'email' => 'Email to Login',
            'password' => 'Password',
        ];
    }
}
