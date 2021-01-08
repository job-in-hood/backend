<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Industry;
use App\Models\User;
use Auth;
use Database\Factories\IndustryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the database should be seeded before each test.
     *
     * @var bool
     */
    protected bool $seed = true;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_loadsCompanyApiWithGetMethod_returns_405()
    {
        $response = $this->get('api/company');

        $response->assertStatus(405);
    }

    public function test_storesTheCompanyWithoutCredentials_returns_401()
    {
        $attributes = Company::factory()->raw();

        $response = $this->postJson(route('api.company.store'), $attributes);

        $response->assertStatus(401);
    }

    public function test_storesTheCompanyWithValidCredentials_returnsCompanyDetails()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $attributes = Company::factory()->raw();

        $response = $this->postJson(route('api.company.store'), $attributes);

        $response->assertStatus(201);
    }
}
