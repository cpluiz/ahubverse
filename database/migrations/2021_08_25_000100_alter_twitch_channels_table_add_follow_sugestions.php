<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTwitchChannelsTableAddFollowSugestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('twitch_channels', function (Blueprint $table) {
            $table->longText('follow_suggestions')->nullable()->after('channel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('twitch_channels', function (Blueprint $table) {
            $table->dropColumn('follow_suggestions');
        });
    }
}
