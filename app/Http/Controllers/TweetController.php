<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Tweet;
//追加（ログイン中のユーザー確認）
use Auth;
//追加(userstableを使用)
use App\Models\User;



class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tweets = Tweet::getAllOrderByUpdated_at();
        return view('tweet.index', [
        'tweets' => $tweets
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tweet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     // バリデーション
     $validator = Validator::make($request->all(), [
     'tweet' => 'required | max:191',
     'description' => 'required',
      ]);
     // バリデーション:エラー
     if ($validator->fails()) {
      return redirect()
      ->route('tweet.create')
      ->withInput()
      ->withErrors($validator);
      }
      
     // create()は最初から用意されている関数
     // 戻り値は挿入されたレコードの情報
     // 🔽 編集 フォームから送信されてきたデータとユーザIDをマージし，DBにinsertする
     //$request->merge()でユーザ ID を追加
     //Auth::user()->idで現在ログインしているユーザの ID を取得することができる（Auth::id()でも可）

     $data = $request->merge(['user_id' => Auth::user()->id])->all();
     
     
     $result = Tweet::create($request->all());
     
     // ルーティング「todo.index」にリクエスト送信（一覧ページに移動）
     return redirect()->route('tweet.index');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tweet = Tweet::find($id);
        return view('tweet.show', ['tweet'=>$tweet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // createと同じ処理
        $tweet = Tweet::find($id);
        
        return view('tweet.edit', ['tweet' => $tweet]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //バリデーション
      $validator = Validator::make($request->all(), [
        'tweet' => 'required | max:191',
        'description' => 'required',
      ]);
      //バリデーション:エラー
      if ($validator->fails()) {
        return redirect()
          ->route('tweet.edit', $id)
          ->withInput()
          ->withErrors($validator);
      }
      //データ更新処理
      // updateは更新する情報がなくても更新が走る（updated_atが更新される）
      $result = Tweet::find($id)->update($request->all());
      // fill()save()は更新する情報がない場合は更新が走らない（updated_atが更新されない）
      // $redult = Tweet::find($id)->fill($request->all())->save();
      return redirect()->route('tweet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Tweet::find($id)->delete();
        return redirect()->route('tweet.index');
    }
    
    //Mypage用の関数
    public function mydata() //web.phpで追加したルーティング
     {
    // Userモデルに定義した関数を実行する．
    $tweets = User::find(Auth::user()->id)->mytweets; //user.phpで定義した関数
    
    return view('tweet.index', [
      'tweets' => $tweets
    ]);
   }
}
