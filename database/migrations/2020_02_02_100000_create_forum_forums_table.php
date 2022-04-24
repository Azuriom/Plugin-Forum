<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_forums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('roles')->nullable();
            $table->string('default_tags')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('forum_categories');
            $table->foreign('parent_id')->references('id')->on('forum_forums')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_forums');
    }
}
