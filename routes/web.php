<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;
//FavoriteController追加
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ログインしていないユーザーはアクセスできないようにする
Route::group(['middleware' => 'auth'], function () {
  //いいねボタン（未実施）のためのルーティング追加
  Route::post('tweet/{tweet}/favorites', [FavoriteController::class, 'store'])->name('favorites');

  //いいねボタン（実施済）のためのルーティング追加
  Route::post('tweet/{tweet}/unfavorites', [FavoriteController::class, 'destroy'])->name('unfavorites');
  
  //マイページを表示するためのルーティングを追加
  //上下逆にしない！！
  Route::get('/tweet/mypage', [TweetController::class, 'mydata'])->name('tweet.mypage');
  Route::resource('tweet', TweetController::class);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
