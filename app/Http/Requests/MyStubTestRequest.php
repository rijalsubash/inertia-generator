<?php

namespace App\Http\Requests;

use App\Models\MyStubTest;
use Illuminate\Foundation\Http\FormRequest;

class MyStubTestRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return MyStubTest::$rules;
    }
}
