<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ユーザID 1 が、自分を除くツイートに対して1ついいねを付ける
        for ($i = 2; $i <= 5; $i++) {
            DB::table('likes')->insert([
                'user_id' => 1,
                'article_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // ユーザID 2 が、ユーザー 1 と自分を除くツイートに対して1ついいねを付ける
        for ($i = 3; $i <= 5; $i++) {
            DB::table('likes')->insert([
                'user_id' => 2,
                'article_id' => $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
