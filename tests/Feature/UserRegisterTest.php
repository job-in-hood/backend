<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_RegisterNewUser_ReceivedGetRequest_ShouldReturnErrorCode()
    {
        // GET Requests not allowed. Response must be 405
        $response = $this->get(route('api.auth.register'));
        $response->assertStatus(405);
    }

    public function test_RegisterNewUser_DuplicateEmail_ShouldReturnError()
    {
        //$this->withoutExceptionHandling();
        $user = User::factory()->create();

        $response = $this->postJson(route('api.auth.register'), [
            "email" => $user->email,
            "name" => $user->name,
            "password" => $user->password,
            "password_confirmation" => $user->password
        ]);

        $response
            ->assertStatus(422)
            ->assertSee('email');
    }

    public function test_RegisterNewUser_ParametersCorrect_ShouldReturnUserInformation()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->make();

        $response = $this->postJson(route('api.auth.register'), [
            "email" => $user->email,
            "name" => $user->name,
            "password" => $user->password,
            "password_confirmation" => $user->password
        ]);

        $response
            ->assertCreated()
            ->assertJsonFragment([
                "email" => $user->email,
                "name" => $user->name
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

    }
}
