<?php

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        $replys = factory(Reply::class)->times(1000)->make()->each(function ($reply, $index) use ($faker){
            $reply->user_id = $faker->randomElement(User::all()->pluck('id')->toArray());
            $reply->topic_id = $faker->randomElement(Topic::all()->pluck('id')->toArray());
        });

        Reply::insert($replys->toArray());
    }

}

