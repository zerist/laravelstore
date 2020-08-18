<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRonghuaCakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ronghua_cakes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->comment('产品名');
            $table->string('content')->comment('产品内容');
            $table->string('image')->comment('二进制图片数据');
            $table->string('price')->comment('零售价');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ronghua_cakes');
    }
}
