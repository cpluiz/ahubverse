<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterViewersTableAddAvatarId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viewers', function (Blueprint $table) {
            $table->integer('avatar_id')->after('user_id');
            $table->dropColumn('display_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viewers', function (Blueprint $table) {
            $table->text('display_name');
            $table->dropColumn('avatar_id');
        });
    }
}
