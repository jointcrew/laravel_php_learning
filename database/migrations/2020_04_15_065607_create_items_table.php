<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->integer('item_id')->autoIncrement();
            $table->char('item_name', 50);
            $table->tinyInteger('apply');
            $table->tinyInteger('selector')->comment('備品 or 私物が入る');
            $table->integer('price');
            $table->char('create_user', 50)->comment('ログインID（user.id)');
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
        Schema::dropIfExists('items');
    }
}
