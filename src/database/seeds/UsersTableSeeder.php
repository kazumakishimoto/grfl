<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'         => 1,
            'name' => 'guest',
            'email' => 'guest@guest.com',
            'password' => 'guest123',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
