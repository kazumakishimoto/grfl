<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            // 'id'         => 1,
            'name'           => config('user.guest_user.name'),
            'age' => 20,
            'gender' => 1,
            'avatar'  => asset(config('user.guest_user.avatar_path')),
            'introduction' => 'ゲストユーザーです',
            'email'          => config('user.guest_user.email'),
            'password'       => Hash::make(config('user.guest_user.password')),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            // 'id'         => 2,
            'name' => 'kazumakishimoto',
            'age' => 29,
            'gender' => 1,
            'avatar' => asset(config('user.avatar_path.kazumakishimoto')),
            'introduction' => '大阪のグルメインフルエンサーです！',
            'email' => 'test2@example.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 3; $i <= 5; $i++) {
            DB::table('users')->insert([
                // 'id'         => $i,
                'name'           => '居酒屋hoge大阪駅前第' . $i . 'ビル店',
                'age' => 20,
                'gender' => 1,
                'avatar' => asset(config('user.avatar_path.default')),
                'introduction' => '大阪駅前第' . $i . 'ビルの居酒屋です',
                'email'          => 'test' . $i . '@example.com',
                'password'       => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}