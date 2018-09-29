<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniquedFieldToParseLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parse_links', function (Blueprint $table) {


            $table->boolean('uniqued'); // Varchar


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parse_links', function (Blueprint $table) {


            $table->dropColumn('uniqued'); // Varchar


        });
    }
}
