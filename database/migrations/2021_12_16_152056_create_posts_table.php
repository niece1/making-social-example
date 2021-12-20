<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            //$table->foreignId('user_id')->index()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
            //in some types of posts (e.g. repost) body may be nullable
            $table->text('body')->nullable();
            $table->unsignedBigInteger('original_post_id')->index()->nullable();
            $table->string('type');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //if original post deleted, also delete reposted(quoted) post
            $table->foreign('original_post_id')->references('id')->on('posts')->onDelete('cascade');
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
