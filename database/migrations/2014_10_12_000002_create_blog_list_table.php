<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogListTable extends Migration
{
    public function up()
    {
        Schema::create('blog_list', function (Blueprint $table) {
            $table->id();
            $table->string('article_title');
            $table->string('article_meta_title')->nullable();
            $table->text('article_meta_description')->nullable();
            $table->integer('slug')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_list');
    }
}
