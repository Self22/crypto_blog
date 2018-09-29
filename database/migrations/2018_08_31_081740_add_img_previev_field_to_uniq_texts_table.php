<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgPrevievFieldToUniqTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uniq_texts', function (Blueprint $table) {


            $table->string('img_preview', 1000); // Varchar

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


            $table->dropColumn('img_preview'); // Varchar


        });
    }
}
