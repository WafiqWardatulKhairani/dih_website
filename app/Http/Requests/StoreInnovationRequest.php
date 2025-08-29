<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInnovationRequest extends FormRequest
{
    public function authorize()
    {
        // ganti sesuai kebutuhan; return true untuk sementara jika sudah ada middleware auth.
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'keywords' => 'nullable|string|max:255',
            'abstract' => 'required|string|max:2000',
            'description' => 'required|string',
            'purpose' => 'required|string',
            'technology_readiness_level' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:2048', // 2MB
            'document' => 'nullable|mimes:pdf|max:5120', // 5MB
            'video_url' => 'nullable|url',
            'author_name' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'status' => 'required|in:Draft,Publish',
            'copyright_status' => 'nullable|string|max:100',
        ];
    }
}
