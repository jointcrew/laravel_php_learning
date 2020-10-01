<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('goods_id')->length(10);
            $table->string('goods_name', 50);
            $table->integer('category')->length(10)->comment('1.食べ物/飲料水、2.家具');
            $table->integer('type')->length(10)->comment('1.ジュース、2.お酒、3.椅子、4.机');
            $table->integer('unit_price')->length(10);
            $table->integer('discount_number')->length(10)->default(0)->comment('0:割引なし 数字の個数から割引');
            $table->integer('discount_rate')->length(10)->default(0)->comment('0:割引率0％なので割引なし、10:10%割引');
            $table->integer('stock')->length(10);
            $table->integer('item_info')->length(2)->nullable()->comment('1.新商品、2.期間限定');
            $table->string('comment', 250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
