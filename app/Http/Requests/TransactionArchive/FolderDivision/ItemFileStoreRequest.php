<?php

namespace App\Http\Requests\TransactionArchive\FolderDivision;

use Illuminate\Foundation\Http\FormRequest;

class ItemFileStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'number' => ['required', 'string', 'unique:folder_items'],
            'folder_id' => ['nullable', 'string'],
            'division_id' => ['nullable', 'string'],
            'company_id' => ['nullable', 'string'],
            'name' => ['required', 'string'],
            'date' => ['required', 'string'],
            'file' => ['required', 'max:50mb'],
        ];

    }

    public function messages() : array
    {
        return [
            'required' => 'The :attribute field is required.',
            'size' => 'Maximum :attribute size to upload is 50MB ',
            'unique' => ':attribute already been used.',

            // tambahkan pesan validasi kustom untuk peran di sini jika diperlukan
        ];
    }
}
