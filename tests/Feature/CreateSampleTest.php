<?php

namespace Tests\Feature;

use App\Models\Sample;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateSampleTest extends TestCase
{
    use RefreshDatabase;

    public function createTest()
    {
        return Test::create([
            'type' => 'talvitis',
            'analysis_service' => 'https://bwsho71wt6.execute-api.eu-west-2.amazonaws.com/api/tests/analyse/',
            'analysis_service_token' => 'xqvzfFppKgFZ3LU8iKbCngOpBdRW2D2d',
        ]);
    }

    /** @test **/
    public function logged_in_users_can_view_the_create_a_sample_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/samples/create');

        $response->assertViewIs('samples.create');
        $response->assertStatus(200);
    }

    /** @test **/
    public function guests_can_not_view_the_create_a_sample_form()
    {
        $response = $this->get('/samples/create');

        $response->assertRedirect('/login');
    }

    /** @test **/
    public function logged_in_users_can_submit_a_valid_sample_form()
    {
        $user  = User::factory()->create();

        $test = $this->createTest();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/samples/create', [
            'test_type' => $test->id,
            'test_strip' => UploadedFile::fake()->image('test.jpg'),
        ]);

        $this->assertEquals(1, Sample::count());

         tap(Sample::first(), function ($sample) use ($response, $test, $user) {
             $response->assertRedirect('/samples');

             $this->assertTrue($sample->test->is($test));
             $this->assertTrue($sample->user->is($user));
             $this->assertStringContainsString($test->type, $sample->test_strip);
             $this->assertStringContainsString('.jpg', $sample->test_strip);
             $this->assertNotNull($sample->result);
             $this->assertIsBool($sample->analysis_failed);
             $this->assertNotNull($sample->reading_one_name);
             $this->assertNotNull($sample->reading_one_value);
             $this->assertNotNull($sample->reading_two_name);
             $this->assertNotNull($sample->reading_two_value);
         });
    }

    /** @test **/
    public function guests_can_not_submit_a_valid_sample_form()
    {
        $test = $this->createTest();

        Storage::fake('public');

        $response = $this->post('/samples/create', [
            'test_type' => $test->id,
            'test_strip' => UploadedFile::fake()->image('test.jpg'),
        ]);

        $this->assertEquals(0, Sample::count());
        $response->assertRedirect('/login');
    }

    /** @test **/
    public function users_must_select_a_test_type()
    {
        $user = User::factory()->create();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/samples/create', [
            'test_type' => '',
            'test_strip' => UploadedFile::fake()->image('test.jpg'),
        ]);

        $response->assertSessionHasErrors('test_type');
        $this->assertEquals(0, Sample::count());
    }

    /** @test **/
    public function users_must_upload_an_image()
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        $response = $this->actingAs($user)->post('/samples/create', [
            'test_type' => $test->id,
            'test_strip' => '',
        ]);

        $response->assertSessionHasErrors('test_strip');
        $this->assertEquals(0, Sample::count());
    }

    /** @test **/
    public function users_must_upload_a_an_image_with_a_valid_mime_type()
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/samples/create', [
            'test_type' => $test->id,
            'test_strip' => UploadedFile::fake()->image('test.svg'),
        ]);

        $response->assertSessionHasErrors('test_strip');
        $this->assertEquals(0, Sample::count());
    }

    /** @test **/
    public function must_be_a_valid_test_type()
    {
        $user = User::factory()->create();

        $test = $this->createTest();

        Storage::fake('public');

        $response = $this->actingAs($user)->post('/samples/create', [
            'test_type' => 999,
            'test_strip' => UploadedFile::fake()->image('test.jgp'),
        ]);

        $response->assertSessionHasErrors('test_type');
        $this->assertEquals(0, Sample::count());
    }
}
