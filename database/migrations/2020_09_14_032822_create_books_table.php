<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
               $table->bigIncrements('id');
               $table->string('author', 100);
               $table->string('title', 100);
               $table->string('description', 500);
               $table->integer('status')->default(App\Book::AVAILABLE);
               $table->integer('rent_count')->default(0);
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
        Schema::dropIfExists('books');
    }
}
