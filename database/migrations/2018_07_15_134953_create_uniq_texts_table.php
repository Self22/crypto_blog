<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uniq_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('anchor', 300);
            $table->string('category', 40);
            $table->string('tag', 20);
            $table->string('time', 40);
            $table->string('date', 40);
            $table->text('news_text');
            $table->string('description', 2000);
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
        Schema::dropIfExists('uniq_texts');
    }
}
