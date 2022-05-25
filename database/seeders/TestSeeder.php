<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tests')->insert([
            ['type' => 'talvitis', 'analysis_service' => 'https://bwsho71wt6.execute-api.eu-west-2.amazonaws.com/api/tests/analyse/', 'analysis_service_token' => 'xqvzfFppKgFZ3LU8iKbCngOpBdRW2D2d', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'samabeties', 'analysis_service' => 'https://keaho22vr7.execute-api.eu-west-2.example.com/api/tests/analyse/', 'analysis_service_token' => Str::random(32), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
