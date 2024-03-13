<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dbmuser')->insert([
            'nik' => "09437",
            'username' => "nkisl",
            'password' => bcrypt("12345"),
            'name' => "Nigel",
            'coyid' => "1",
            'level' => "1",
        ]);
    }
}
