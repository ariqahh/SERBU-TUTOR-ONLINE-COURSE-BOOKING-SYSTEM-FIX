<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'mentor_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'quota' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,published',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama kursus harus diisi.',
            'description.required' => 'Deskripsi kursus harus diisi.',  
            'mentor_id.required' => 'Mentor harus diisi.',
            'mentor_id.exists' => 'Mentor tidak ditemukan.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'File harus berupa gambar (jpeg, png, jpg, gif, svg).',
            'image.max' => 'File gambar maksimal 2MB.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal.',
            'end_date.required' => 'Tanggal selesai harus diisi.',
            'end_date.date' => 'Tanggal selesai harus berupa tanggal.',
            'quota.required' => 'Kuota kursus harus diisi.',
            'quota.integer' => 'Kuota kursus harus berupa angka.',
            'quota.min' => 'Kuota kursus minimal 0.',
            'price.required' => 'Harga kursus harus diisi.',
            'price.numeric' => 'Harga kursus harus berupa angka.',
            'price.min' => 'Harga kursus minimal 0.',
            'status.required' => 'Status kursus harus diisi.',
            'status.in' => 'Status kursus harus berupa draft atau published.',
        ];
    }
}
