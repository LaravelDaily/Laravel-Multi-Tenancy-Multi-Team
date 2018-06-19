<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTeamUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'team_id')) {
            Schema::table('users', function (Blueprint $table) {
                // index from 2018_06_13_201720_add_5b2151a03f6ed_relationships_to_user_table.php
                $table->dropForeign('171563_5b21519b178e4');
                $table->dropColumn('team_id');
            });
        }

        Schema::create('team_user', function (Blueprint $table) {
            $table->unsignedInteger('team_id');
            $table->foreign('team_id')->references('id')->on('teams');

            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_user', function (Blueprint $table) {
            $table->dropIfExists();
        });
    }
}
