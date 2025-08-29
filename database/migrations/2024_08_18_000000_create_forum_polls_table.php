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
        Schema::create('forum_polls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('discussion_id');
            $table->string('question');
            $table->boolean('multiple_choice')->default(false);
            $table->boolean('results_before_vote')->default(false);
            $table->boolean('remove_vote')->default(false);
            $table->timestamp('closes_at')->nullable();
            $table->timestamps();

            $table->foreign('discussion_id')->references('id')->on('forum_discussions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_polls');
    }
};
