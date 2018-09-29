<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOriginalLinkColumnToUniqtextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uniq_texts', function (Blueprint $table) {


            $table->integer('original_link'); // Varchar

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uniq_texts', function (Blueprint $table) {


            $table->dropColumn('original_link'); // Varchar


        });
    }
}
