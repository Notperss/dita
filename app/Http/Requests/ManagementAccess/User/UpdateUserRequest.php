<?php

namespace App\Http\Requests\ManagementAccess\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'nik' => [
                'required', 'string', 'max:50', Rule::unique('detail_users')->ignore($this->user),
            ],
            'name' => [
                'required', 'string', 'max:255',
            ],
            'job_position' => [
                'required', 'string', 'max:255',
            ],
            'type_user_id' => [
                'required', 'string', 'max:255',
            ],
            'status' => [
                'required', 'string', 'max:255',
            ],
            'profile_photo_path' => [
                'mimes:png,jpg,jpeg',
            ],
            'email' => [
                'required', 'email', Rule::unique('users')->ignore($this->user),
            ],
            'password' => 'confirmed',
            // add validation for role this here
        ];
    }
    public function messages() : array
    {
        return [
            'nik.required' => 'Kolom NIK wajib diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.max' => 'NIK tidak boleh lebih dari :max karakter.',

            'name.required' => 'Kolom nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',

            'job_position.required' => 'Kolom posisi pekerjaan wajib diisi.',
            'job_position.string' => 'Posisi pekerjaan harus berupa teks.',
            'job_position.max' => 'Posisi pekerjaan tidak boleh lebih dari :max karakter.',

            'type_user_id.required' => 'Kolom Tipe User pengguna wajib diisi.',
            'type_user_id.string' => 'Tipe User pengguna harus berupa teks.',
            'type_user_id.max' => 'Tipe User pengguna tidak boleh lebih dari :max karakter.',

            'status.required' => 'Kolom status wajib diisi.',
            'status.string' => 'Status harus berupa teks.',
            'status.max' => 'Status tidak boleh lebih dari :max karakter.',

            'profile_photo_path.mimes' => 'Foto profil harus berupa file dengan tipe: :values.',

            'email.required' => 'Kolom alamat email wajib diisi.',
            'email.email' => 'Alamat email harus berupa alamat email yang valid.',
            'email.unique' => 'Alamat email sudah digunakan.',

            'password.required' => 'Kolom kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            // tambahkan pesan validasi kustom untuk peran di sini jika diperlukan
        ];
    }
}
