<?php

use Illuminate\Database\Seeder;

class ReplyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = \App\Models\User::all()->pluck('id')->all();
        $topic_ids = \App\Models\Topic::all()->pluck('id')->all();

        $faker = app(\Faker\Generator::class);

        $replies = factory(\App\Models\Reply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply, $index) use ($faker, $user_ids, $topic_ids) {
                $reply->user_id = $faker->randomElement($user_ids);
                $reply->topic_id = $faker->randomElement($topic_ids);
            });

        \App\Models\Reply::insert($replies->toArray());
    }
}
