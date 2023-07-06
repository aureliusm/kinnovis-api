<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password',
            'device_name' => 'Test Device',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'status' => 'OK',
            ]);
    }

    public function testUnsuccessfulLogin()
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'wrong@email.com',
            'password' => 'incorrect',
            'device_name' => 'Test Device',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }
}
