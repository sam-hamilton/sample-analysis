<?php

namespace App\Analysis;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AwsAnalysisService
{
    private $sample;
    public $response;

    public function __construct($sample)
    {
        $this->sample = $sample;
    }

    public function analyse()
    {
        $test = $this->sample->test;

        $this->response = Http::withToken($test->analysis_service_token)
            ->attach('image', Storage::disk('public')->get($this->sample->test_strip), basename($this->sample->test_strip))
            ->post($test->analysis_service . $this->sample->id, [
                'test_type' => $test->type,
            ])->json();

        return $this;
    }

    public function save()
    {
        if (is_null($this->response)) {
            return false;
        }

        return $update = $this->sample->fill([
            'result' => $this->response['data']['result'],
            'analysis_failed' => $this->response['data']['failed'],
            'reading_one_name' => $this->response['data']['readings'][0]['name'],
            'reading_one_value' => $this->response['data']['readings'][0]['value'],
            'reading_two_name' => $this->response['data']['readings'][1]['name'],
            'reading_two_value' => $this->response['data']['readings'][1]['value'],
        ])->save();
    }
}
