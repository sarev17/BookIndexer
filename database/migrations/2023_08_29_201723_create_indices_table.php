<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('parent_index_id')->nullable();
            $table->text('title');
            $table->integer('page');
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('parent_index_id')->references('id')->on('indices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indices', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropForeign(['parent_index_id']);
        });
        Schema::dropIfExists('indices');
    }
};
