<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_RegisterNewUser_ReceivedGetRequest_ShouldReturnErrorCode() {
        // GET Requests not allowed. Response must be 405
        $response = $this->get(route('api.auth.register'));
        $response->assertStatus(405);
    }

    public function test_RegisterNewUser_DuplicateEmail_ShouldReturnError() {
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $password = Str::random();

        $response = $this->postJson(route('api.auth.register'),[
            "email" => $user->email,
            "name" => $user->name,
            "password" => $password,
            "password_confirmation" => $password
        ]);

        $response->assertStatus(422);
        $response->assertSee('email');
    }

    public function test_RegisterNewUser_ParametersCorrect_ShouldReturnUserInformation() {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->make();
        $password = Str::random();

        $response = $this->postJson(route('api.auth.register'),[
            "email" => $user->email,
            "name" => $user->name,
            "password" => $password,
            "password_confirmation" => $password
        ]);

        // Return 201
        $response->assertCreated();

        // Check database
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        // Check response
        $response->assertJsonFragment([
            "email" => $user->email,
            "name" => $user->name
        ]);
    }
}