<?php

namespace Tests\Feature;

use App\Analysis\AwsAnalysisService;
use App\Models\Sample;
use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @group integration
 */
class AwsAnalysisServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $test;
    protected $sample;

    public function setUp(): void
    {
        parent::setUp();

        $this->test = Test::create([
            'type' => 'diabetes',
            'analysis_service' => env('APP_URL') . '/api/analysis/',
            'analysis_service_token' => 'xqvzfFppKgFZ3LU8iKbCngOpBdRW2D2d',
        ]);

        $this->sample = Sample::create([
            'user_id' => 999,
            'test_id' => $this->test->id,
            'test_strip' => '/test/test.png',
        ]);
    }

    /** @test **/
    public function can_get_valid_response_from_the_api()
    {
        $response = (new AwsAnalysisService($this->sample))->analyse()->response;

        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('result', $response['data']);
        $this->assertIsArray($response['data']);
        $this->assertArrayHasKey('failed', $response['data']);
        $this->assertArrayHasKey('readings', $response['data']);
        $this->assertArrayHasKey('readings', $response['data']);
        $this->assertIsArray($response['data']['readings']);
        foreach ($response['data']['readings'] as $reading) {
            $this->assertArrayHasKey('name', $reading);
            $this->assertArrayHasKey('value', $reading);
        }

        $this->assertIsString($response['data']['result']);
        $this->assertIsBool($response['data']['failed']);
        foreach ($response['data']['readings'] as $reading) {
            $this->assertIsString($reading['name']);
            $this->assertIsNumeric($reading['value']);
        }
    }

    /** @test **/
    public function can_populate_sample_from_api_response()
    {
        $response = (new AwsAnalysisService($this->sample))->analyse()->save();

        $this->assertIsString($this->sample->result);
        $this->assertIsBool($this->sample->analysis_failed);
        $this->assertIsString($this->sample->reading_one_name);
        $this->assertIsNumeric($this->sample->reading_one_value);
        $this->assertIsString($this->sample->reading_two_name);
        $this->assertIsNumeric($this->sample->reading_two_value);
    }
}
