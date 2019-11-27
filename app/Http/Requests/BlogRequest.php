<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        $blog = $this->route('blog');
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
                        'blog_title' => 'required|max:255',
                        'blog_description' => 'required|max:255',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'blog_title' => 'required|max:255',
                        'blog_description' => 'required|max:255',
                    ];
                }
            default:break;
        }
    }

    public function attributes()
    {
        return [
            'blog_title' => 'Title of Blog',
            'blog_description' => 'Blog Description',
        ];
    }
}
