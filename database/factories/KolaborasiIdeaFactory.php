<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KolaborasiIdeaFactory extends Factory
{
    public function definition()
    {
        $kategori = ['teknologi', 'lingkungan', 'ekonomi', 'kesehatan', 'pendidikan', 'smart-city'];
        
        return [
            'user_id' => \App\Models\User::factory(),
            'judul' => $this->faker->sentence(6),
            'kategori' => $this->faker->randomElement($kategori),
            'deskripsi_singkat' => $this->faker->text(200),
            'latar_belakang' => $this->faker->paragraphs(3, true),
            'solusi' => $this->faker->paragraphs(2, true),
            'estimasi_waktu' => $this->faker->randomElement(['1-3', '3-6', '6-12', '12+']),
            'kompleksitas' => $this->faker->randomElement(['low', 'medium', 'high']),
            'dampak' => $this->faker->paragraphs(2, true),
            'status' => $this->faker->randomElement(['draft', 'submitted', 'under_review', 'approved']),
        ];
    }
}