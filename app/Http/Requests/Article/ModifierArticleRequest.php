<?php

namespace App\Http\Requests\Article;

use Illuminate\Support\Facades\Gate;
use App\Traits\Article\WithValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ModifierArticleRequest extends FormRequest
{
    use WithValidation;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return Gate::allows('add_article');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = null;
        if (is_object($this->article)) $id = $this->article->id;
        else $id = $this->article;

        return $this->validationRules($id);
    }

    public function messages()
    {
        return $this->ValidationMessages();
    }

    /**
     * Si la validation échoue
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $message = "Les champs ne sont pas bien remplis";
        if (request()->ajax()) {
            return response()->json([
                "errors" => $validator->errors(),
                "message" => $message
            ], 422);
        }
        return back()->withErrors($validator)->withInput();
    }


    /**
     * Traitements avant la validation
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            "categories" => collect($this->categories)->pluck('id')->toArray(),
        ]);
    }
}
