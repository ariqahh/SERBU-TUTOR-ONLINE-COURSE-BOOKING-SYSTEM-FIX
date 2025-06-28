<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourseBookingRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'Kursus harus diisi.',
            'course_id.exists' => 'Kursus tidak ditemukan.',
            'payment_proof.required' => 'Bukti pembayaran harus diisi.',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar.',
            'payment_proof.mimes' => 'Bukti pembayaran harus berupa gambar (jpeg, png, jpg, gif, svg).',
            'payment_proof.max' => 'Bukti pembayaran maksimal 2MB.',
        ];
    }
}
