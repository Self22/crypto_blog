<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->increments('id');
            $table->string('title',255); // Varchar
            $table->string('seo_title',70); // Varchar
            $table->string('description',255); // Varchar
            $table->text('content');   // text
            $table->boolean('is_active');
            $table->unsignedInteger('category_id');
            $table->string('slug')->nullable()->index();
            $table->string('picture_name',255); // Varchar
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
        Schema::dropIfExists('posts');
    }
}
