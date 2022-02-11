<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Article;

class Article_tagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            DB::table('article_tag')->insert([
                [
                    'article_id' => $i,
                    'tag_id' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
