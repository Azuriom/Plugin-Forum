<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileColumnsToForumUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forum_users', function (Blueprint $table) {
            $table->text('about')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->string('discord')->nullable();
            $table->string('twitter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_users', function (Blueprint $table) {
            $table->dropColumn(['about', 'website', 'location', 'discord', 'twitter']);
        });
    }
}
