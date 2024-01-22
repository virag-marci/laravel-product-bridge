<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for valid login credentials.
     */
    public static function validCredentialsDataProvider(): array
    {
        return [
            'valid credentials' => ['password'],
            'valid credentials 2' => ['password-2'],
            'valid credentials 3' => ['password-3'],
        ];
    }

    /**
     * Data provider for invalid login credentials.
     */
    public static function invalidCredentialsDataProvider(): array
    {
        return [
            'invalid password' => ['not-the-password'],
            'invalid password 2' => ['not-the-password-2'],
        ];
    }

    /**
     * @dataProvider validCredentialsDataProvider
     */
    public function test_a_user_can_login($password)
    {
        $user = User::factory()->create([
            'password' => bcrypt($password)
        ]);

        $response = $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * @dataProvider invalidCredentialsDataProvider
     */
    public function test_a_user_can_not_login_with_invalid_credentials($password)
    {
        $user = User::factory()->create();

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => $password,
        ])->assertStatus(401);
    }

    public function test_a_user_can_access_their_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson(route('user'))
            ->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }
}
