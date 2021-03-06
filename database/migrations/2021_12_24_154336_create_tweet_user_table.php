<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweetUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweet_user', function (Blueprint $table) {
            $table->id();
            // ð½ ããããè¿½å 
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tweet_id');
            //foreign()	å¼æ°ã®ã«ã©ã ãå¤é¨ã­ã¼å¶ç´ã§ãããã¨ãç¤ºã
            //references()	â ã§åç§ããå¤é¨ã­ã¼ãè¨­å®ããï¼
            //on()	â ã§åç§ãããã¼ãã«ãè¨­å®ããï¼
            //onDelete()	â ã§åç§ãã¦ãããã¼ã¿ãåé¤ãããå ´åã«ä¸­éãã¼ãã«ã®ãã¼ã¿ãåé¤ããè¨­å®ï¼
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade');
            $table->unique(['user_id', 'tweet_id']);
            // ð¼ä¸­éãã¼ãã«ã® user_id ã¯ users ãã¼ãã«ã® id ãåç§ãã¦ãã¦ï¼users ãã¼ãã«ã®ãã¼ã¿ãåé¤ãããã¨ä¸­éãã¼ãã«ã®ãã¼ã¿ãåé¤ããã 
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
        Schema::dropIfExists('tweet_user');
    }
}
