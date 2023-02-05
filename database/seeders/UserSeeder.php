<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Richard', 'email' => 'richard@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jon', 'email' => 'jon@example.com', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
