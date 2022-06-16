<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            Comment::create([
                'user_id' => 1,
                'article_id' => $i,
                'comment' => 'よろしくお願いします',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}