<?php

namespace App\Http\Requests\Post;

use App\Enums\PostCurrnencySalary;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $rules =  [
            'company' => [
                'string',
                'nullable',
            ],
            'language' => [
                'required',
                'array',
                'filled',
            ],
            'city' => [
                'required',
                'string',
                'filled',
            ],
            'district' => [
                'nullable',
                'string',
            ],
            'currency_salary' => [
                'nullable',
                'numeric',
                Rule::in(PostCurrnencySalary::getValues()),
            ],
            'number_applicants' => [
                'nullable',
                'numeric',
                'min:1',
            ],
            'start_date' => [
                'nullable',
                'date',
                'before:end_date',
            ],
            'end_date' => [
                'nullable',
                'date',
                'after:start_date',
            ],
            'title' => [
                'nullable',
                'string',
                'filled',
                'min:3',
                'max:255',
            ],
            'slug' => [
                'nullable',
                'string',
                'filled',
                'min:3',
                'max:255',
                Rule::unique(Post::class),
            ],
        ];
        $rules['min_salary'] = [
          'nullable',
          'numeric',
        ];
        if(isset($this->max_salary)){
            $rules['min_salary'][] = 'lt:max_salary';
        }
        $rules['max_salary'] = [
            'nullable',
            'numeric',
        ];
        if(isset($this->min_salary)){
            $rules['max_salary'][] = 'gt:max_salary';
        }
        return $rules;
    }
}
