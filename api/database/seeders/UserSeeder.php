<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'name'        => Str::random(10),
            'email'       => Str::random(10).'@gmail.com',
            'api_token'   => '80ed01f7ef2e4e538a6d24e50088495f',
            'status_flag' => 1
        ]);
    }
}
