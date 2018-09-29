<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {


            $table->string('uniq_texts_title'); // Varchar
            $table->string('uniq_texts_h1'); // Varchar
            $table->string('uniq_texts_descr'); // Varchar

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('uniq_texts_title'); // Varchar
            $table->dropColumn('uniq_texts_h1'); // Varchar
            $table->dropColumn('uniq_texts_descr'); // Varchar
        });
    }
}
