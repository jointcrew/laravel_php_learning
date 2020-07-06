<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->integer('purchase_id')->length(10)->autoIncrement();
            $table->integer('goods_id')->length(10)->unsigned();
            $table->integer('unit_price')->length(10);
            $table->integer('purchase_number')->length(10);
            $table->integer('total_price')->length(10)->comment('割引額を含めない金額');
            $table->integer('discount_price')->length(10)->default(0)->comment('割引額');
            $table->integer('purchase_price')->length(10)->comment('割引後の金額');
            $table->bigInteger('user_id')->length(20)->unsigned();
            $table->timestamp('created_at');
            $table->foreign('goods_id')->references('goods_id')->on('goods')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase');
    }
}
