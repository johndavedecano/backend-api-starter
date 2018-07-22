<?php namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|alpha_num|min:6|max:16|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6|max:16'
        ];
    }
}
