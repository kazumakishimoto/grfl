<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\User;
use App\Models\Article;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $article = Article::create([
                'user_id'    => $i,
                'body'       => 'これはテスト投稿です' . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $article->tags()->attach(Tag::inRandomOrder()->first());

        }
    }
}
