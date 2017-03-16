<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{

    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 70)->nullable();
            $table->string('slug', 50);
            $table->string('image', 150)->nullable();
            $table->text('content');
            $table->string('keywords', 150)->nullable();
            $table->tinyInteger('public')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('news');
    }
}
