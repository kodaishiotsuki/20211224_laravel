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
            // 🔽 ここから追加
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tweet_id');
            //foreign()	引数のカラムが外部キー制約であることを示す
            //references()	↑ で参照する外部キーを設定する．
            //on()	↑ で参照するテーブルを設定する．
            //onDelete()	↑ で参照しているデータが削除された場合に中間テーブルのデータも削除する設定．
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade');
            $table->unique(['user_id', 'tweet_id']);
            // 🔼中間テーブルの user_id は users テーブルの id を参照していて，users テーブルのデータが削除されると中間テーブルのデータも削除される 
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
