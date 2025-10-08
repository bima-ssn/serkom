<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        // Tambahkan validasi khusus untuk role siswa
        if ($this->user()->role === 'siswa') {
            $rules['nis_nip'] = ['nullable', 'string', 'max:20'];
            $rules['kelas'] = ['nullable', 'string', 'max:50'];
            $rules['jurusan'] = ['nullable', 'string', 'max:100'];
            $rules['phone'] = ['nullable', 'string', 'max:15'];
        }

        return $rules;
    }
}
