<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 所有用户ID
        $user_ids = User::all()->pluck('id')->toArray();

        // 所有话题ID
        $topic_ids = Topic::all()->pluck('id')->toArray();

        // faker实例
        $faker = app(Faker\Generator::class);

        $replys = factory(Reply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply, $index)
            use($user_ids, $topic_ids, $faker)
            {
                // 随机用户ID
                $reply->user_id = $faker->randomElement($user_ids);

                // 随机话题ID
                $reply->topic_id = $faker->randomElement($topic_ids);
        });

        // 数据转换为数组，并插入数据库
        Reply::insert($replys->toArray());
    }

}

