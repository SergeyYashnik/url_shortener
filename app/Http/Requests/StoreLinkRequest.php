<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Ссылка которую нужно сократить
            'url' => ['required', 'string', 'url', 'max:2048'],
        ];
    }
}
