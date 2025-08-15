<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        factory(Post::class, 10)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            }
        ]);
    }
}
