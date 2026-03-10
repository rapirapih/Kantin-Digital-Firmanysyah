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
        $user = $this->user();

        $rules = [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:laki-laki,perempuan'],
            'foto_profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'no_whatsapp' => ['nullable', 'string', 'max:20'],
        ];

        if ($user->role === 'penjual') {
            $rules['nik'] = ['required', 'string', 'max:20'];
        } else {
            $rules['tipe_pengguna'] = ['required', 'in:guru,siswa'];

            if ($this->input('tipe_pengguna') === 'siswa') {
                $rules['nis'] = ['required', 'string', 'max:20'];
                $rules['kelas'] = ['required', 'string', 'max:20'];
                $rules['jurusan'] = ['required', 'string', 'max:100'];
            } elseif ($this->input('tipe_pengguna') === 'guru') {
                $rules['nik'] = ['required', 'string', 'max:20'];
                $rules['kelas'] = ['nullable', 'string', 'max:20'];
                $rules['jurusan'] = ['nullable', 'string', 'max:100'];
            }
        }

        return $rules;
    }
}
