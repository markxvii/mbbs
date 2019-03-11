<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categries = [
            [
                'name' => 'PHP',
                'description' => '最好的编程语言',
            ],
            [
                'name'=>'音乐',
                'description' => 'Music is the answer.',
            ],
            [
                'name' => '穿搭',
                'description' => '对自己好点。'
            ],
            [
                'name' => '好书',
                'description' => '有趣的灵魂万里挑一。',
            ]
        ];

        DB::table('categories')->insert($categries);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();//删除表并将递增字段重置为0
    }
}
