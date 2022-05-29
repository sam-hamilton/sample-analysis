<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')->pluck('id');
        $tests = DB::table('tests')->get();

        foreach ($tests as $test) {
            DB::table('samples')->insert([
                ['user_id' => rand($users->min(), $users->max()), 'test_id' => $test->id, 'test_strip' => 'test/test.png', 'result' => 'Positive', 'analysis_failed' => false, 'reading_one_name' => 'control', 'reading_one_value' => 0, 'reading_two_name' => 'detect', 'reading_two_value' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => rand($users->min(), $users->max()), 'test_id' => $test->id, 'test_strip' => 'test/test.png', 'result' => 'Failed To Detect Cartridge', 'analysis_failed' => true, 'reading_one_name' => 'control', 'reading_one_value' => 0, 'reading_two_name' => 'detect', 'reading_two_value' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['user_id' => rand($users->min(), $users->max()), 'test_id' => $test->id, 'test_strip' => 'test/test.png', 'result' => 'Invalid Test (no control line detected)', 'analysis_failed' => false, 'reading_one_name' => 'control', 'reading_one_value' => 1, 'reading_two_name' => 'detect', 'reading_two_value' => 0.96, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
}
