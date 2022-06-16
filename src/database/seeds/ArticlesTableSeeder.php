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
        $article = Article::create([
            'user_id'    => '1',
            'pref_id'    => '27',
            'title'       => 'guest',
            'body'       => 'guest',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $article = Article::create([
            'user_id'    => '2',
            'pref_id'    => '27',
            'title'       => '広告案件募集',
            'body'       => '大阪の飲食店でSNS広告します',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        for ($i = 3; $i <= 5; $i++) {
            $article = Article::create([
                'user_id'    => $i,
                'pref_id'    => '27',
                'title'       => 'インフルエンサー募集',
                'body'       => 'SNS広告できる方はコメント下さい',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $article->tags()->attach(Tag::inRandomOrder()->first());

        }
    }
}