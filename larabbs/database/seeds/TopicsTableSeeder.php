<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $category_ids = \App\Models\Category::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $topics = factory(\App\Models\Topic::class)
            ->times(100)
            ->make()
            ->each(function ($topic, $index) use ($user_ids, $category_ids, $faker) {
                $topic->user_id = $faker->randomElement($user_ids);
                $topic->category_id = $faker->randomElement($category_ids);
            });

        \App\Models\Topic::insert($topics->toArray());
    }
}
