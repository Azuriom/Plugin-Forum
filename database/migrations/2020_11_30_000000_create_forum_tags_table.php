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
        Schema::create('forum_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('forum_discussion_tag', function (Blueprint $table) {
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('discussion_id');

            $table->foreign('tag_id')->references('id')->on('forum_tags')->cascadeOnDelete();
            $table->foreign('discussion_id')->references('id')->on('forum_discussions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_discussion_tag');
        Schema::dropIfExists('forum_tags');
    }
};
