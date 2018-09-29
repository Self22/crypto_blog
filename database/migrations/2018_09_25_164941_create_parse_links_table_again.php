<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParseLinksTableAgain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parse_links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('href', 200);
            $table->string('anchor', 300);
            $table->string('site', 20);
            $table->string('category', 40);
            $table->string('tag', 20);
            $table->string('time', 40);
            $table->string('date', 40);
            $table->text('news_text');
            $table->string('description', 2000);
            $table->string('img_preview', 2000);
            $table->boolean('uniqued');
            $table->string('slug', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parse_links');
    }
}
