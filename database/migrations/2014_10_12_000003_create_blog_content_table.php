<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogContentTable extends Migration
{
    public function up()
    {
        Schema::create('blog_content', function (Blueprint $table) {
            $table->id();
            $table->string('article_type');
            $table->text('article_text');
            $table->integer('article_number')->nullable();
            $table->integer('slug')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_content');
    }
}
