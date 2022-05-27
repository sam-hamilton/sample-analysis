<?php

namespace Tests\Feature;

use App\Models\Sample;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewSamplesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function logged_in_users_can_view_samples_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/samples');

        $response->assertViewIs('samples.index');
        $response->assertStatus(200);
    }

    /** @test **/
    public function guests_can_not_view_the_samples_index()
    {
        $response = $this->get('/samples');

        $response->assertRedirect('/login');
    }

    /** @test **/
    public function users_see_expected_samples()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $test = Test::create([
            'type' => 'talvitis',
            'analysis_service' => 'https://example.com/test/',
            'analysis_service_token' => 'token123',
        ]);

        $sample = Sample::create([
            'user_id' => '1',
            'test_id' => '1',
            'test_strip' => 'test/example.jpg',
            'result' => 'Positive',
            'analysis_failed' => false,
            'reading_one_name' => 'control',
            'reading_one_value' => '333',
            'reading_two_name' => 'detect',
            'reading_two_value' => '444',
        ]);

        $response = $this->actingAs($user)->get("/samples");

        $response->assertSee('example.jpg');
        $response->assertSee('Positive');
        $response->assertSee('Successful');
        $response->assertSee('control');
        $response->assertSee('333');
        $response->assertSee('detect');
        $response->assertSee('444');
    }

    /** @test **/
    public function ensure_test_filter_is_populated()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $test = Test::create([
            'type' => 'talvitis',
            'analysis_service' => 'https://example.com/test/',
            'analysis_service_token' => 'token123',
        ]);

        $response = $this->actingAs($user)->get('/samples');

        $response->assertSeeInOrder(['All', 'talvitis']);
    }

    /** @test **/
    public function ensure_user_filter_is_populated()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'name' => 'Super Jack',
        ]);

        $response = $this->actingAs($user)->get('/samples');

        $response->assertSeeInOrder(['All', 'Super Jack']);
    }

    /** @test **/
    public function ensure_outcome_filter_is_populated()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $test = Test::create([
            'type' => 'talvitis',
            'analysis_service' => 'https://example.com/test/',
            'analysis_service_token' => 'token123',
        ]);

        $sample = Sample::create([
            'user_id' => '1',
            'test_id' => '1',
            'test_strip' => 'test/example.jpg',
            'result' => 'Positive',
            'analysis_failed' => false,
            'reading_one_name' => 'control',
            'reading_one_value' => '333',
            'reading_two_name' => 'detect',
            'reading_two_value' => '444',
        ]);

        $response = $this->actingAs($user)->get('/samples');

        $response->assertSeeInOrder(['All', 'Positive', 'Positive']);
    }
}
