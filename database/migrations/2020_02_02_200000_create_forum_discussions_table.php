<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('forum_id');
            $table->string('title');
            $table->unsignedInteger('views')->default(0);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('forum_id')->references('id')->on('forum_forums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_discussions');
    }
};
