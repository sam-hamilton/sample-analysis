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
            ['type' => 'diabetes', 'analysis_service' => env('APP_URL') . '/api/analysis/', 'analysis_service_token' => 'xqvzfFppKgFZ3LU8iKbCngOpBdRW2D2d', 'created_at' => now(), 'updated_at' => now()],
            ['type' => 'urine tracked infection', 'analysis_service' => env('APP_URL') . '/api/analysis/', 'analysis_service_token' => Str::random(32), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
