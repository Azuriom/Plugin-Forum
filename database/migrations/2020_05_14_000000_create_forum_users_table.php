<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('about')->nullable();
            $table->text('signature')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->string('discord')->nullable();
            $table->string('twitter')->nullable();
            $table->timestamp('last_seen_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_users');
    }
};
