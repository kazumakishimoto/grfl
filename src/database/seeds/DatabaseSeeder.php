<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ArticlesTableSeeder::class,
            TagsTableSeeder::class,
            FollowsTableSeeder::class,
            CommentsTableSeeder::class,
            LikesTableSeeder::class,
            // RoomsTableSeeder::class,
            // MessagesTableSeeder::class,
            // EntriesTableSeeder::class,
        ]);
    }
}
