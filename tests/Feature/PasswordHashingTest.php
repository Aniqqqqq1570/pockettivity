<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordHashingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_log_in_with_a_bcrypt_password_created_by_the_factory(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.process'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_registration_stores_a_laravel_supported_password_hash(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Dina',
            'email' => 'dina@example.test',
            'password' => 'secure-pass-123',
            'password_confirmation' => 'secure-pass-123',
        ])->assertRedirect(route('login'));

        $user = User::where('email', 'dina@example.test')->firstOrFail();

        $this->assertTrue(Hash::check('secure-pass-123', $user->password));
        $this->assertNotSame('secure-pass-123', $user->password);
    }

    public function test_non_bcrypt_stored_hash_is_rejected_without_an_uncaught_exception(): void
    {
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update(['password' => 'legacy-placeholder']);

        $this->post(route('login.process'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('home'))
            ->assertSessionHasErrors(['email' => 'Email atau password salah.']);

        $this->assertGuest();
    }
}
