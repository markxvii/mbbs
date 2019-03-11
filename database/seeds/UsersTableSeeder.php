<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(\Faker\Generator::class);

        //头像假数据
        $avatars = [
            "https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200",
            "https://www.gravatar.com/avatar/00000000000000000000000000000000?d=monsterid&f=y&s=200",
        ];

        //生成数据集合
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index) use ($faker, $avatars) {
                // 从头像数组中随机取出一个并赋值
                $user->avatar = $faker->randomElement($avatars);
            });

        //让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        //单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'Marc';
        $user->email = 'markxvii@outlook.com';
        $user->avatar = 'https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?s=200';
        $user->save();
    }
}
