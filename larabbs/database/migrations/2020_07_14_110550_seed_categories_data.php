<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'=>'share',
                'description'=>'share idea, share knowledge',
            ],
            [
                'name'=>'lesson',
                'description'=>'web & ui',
            ],
            [
                'name'=>'Q&A',
                'description'=>'question & answer',
            ],
            [
                'name'=>'notice',
                'description'=>'site notice'
            ],
        ];
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
