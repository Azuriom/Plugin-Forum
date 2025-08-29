<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_poll_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('option_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('option_id')->references('id')->on('forum_poll_options')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['option_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_poll_votes');
    }
};
