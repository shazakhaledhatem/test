<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Illuminate\Database\Seeder;

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
      [
        'name'=>'shaza'	,
        'email'=>'shaza@gmail.com',
        'password'=>bcrypt('1234'),




      ],
      [
        'name'=>'hala'	,
        'email'=>'hala@gmail.com',
        'password'=>bcrypt('password'),




      ],
     ]);
    }
}
