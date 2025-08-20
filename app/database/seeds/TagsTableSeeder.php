<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'name' => '寝顔'
            ],
            [
                'name' => '散歩'
            ],
            [
                'name' => 'もぐもぐ'
            ]
        ];

        foreach($tags as $tag) {
            DB::table('tags')->insert($tag);
        }
    }
}
