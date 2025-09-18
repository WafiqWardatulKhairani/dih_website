<?php

namespace Tests\Feature\Livewire;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_register_with_valid_data()
    {
        Storage::fake('public'); // fake storage supaya upload nggak beneran ke disk

        $document = UploadedFile::fake()->create('document.pdf', 100); // 100 KB
        $avatar = UploadedFile::fake()->image('avatar.jpg');

        Livewire::test('auth.user-register')
            ->set('name', 'Wafiq Wardatul')
            ->set('institution_name', 'Sekolah Contoh')
            ->set('phone', '08123456789')
            ->set('address', 'Jakarta')
            ->set('email', 'wafiq@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->set('role', 'akademisi')
            ->set('document', $document)
            ->set('avatar', $avatar)
            ->call('register');

        // Pastikan user tersimpan
        $this->assertDatabaseHas('users', [
            'email' => 'wafiq@example.com',
            'institution_name' => 'Sekolah Contoh',
            'role' => 'akademisi',
        ]);

        // Pastikan file tersimpan di storage fake
        Storage::disk('public')->assertExists("documents/akademisi/sekolah_contoh_document.pdf");
        Storage::disk('public')->assertExists("avatars/akademisi/sekolah_contoh_avatar.jpg");
    }

    #[Test]
    public function registration_fails_if_required_fields_missing()
    {
        Livewire::test('auth.user-register')
            ->set('name', '')
            ->set('institution_name', '')
            ->set('email', '')
            ->set('password', '')
            ->set('password_confirmation', '')
            ->set('role', '')
            ->call('register')
            ->assertHasErrors([
                'name' => 'required',
                'institution_name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required',
            ]);
    }
}
