<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo;
use App\Models\Tag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //authミドルウェアを紐づけている
        //HomeControllerのアクションが起動するたびに
        //authミドルウェアによって認証チェックが行われる
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //ログインしているユーザー情報取得
        $user = Auth::user();
        //メモ一覧を取得
        //where()の第一引数に絞り込み項目
        //第二引数に絞り込みに使用する値
        //whereを2つ繋げて「&&」の意味
        $memos = Memo::where('user_id', $user['id'])
        ->where('status', 1)
        ->orderBy('updated_at', 'DESC')
        ->get();
        return view('home', ['memos' => $memos]);
    }

    public function create()
    {
        //ログインしているユーザー情報取得
        $user = Auth::user();
        //メモ一覧を取得
        //where()の第一引数に絞り込み項目
        //第二引数に絞り込みに使用する値
        //whereを2つ繋げて「&&」の意味
        $memos = Memo::where('user_id', $user['id'])
        ->where('status', 1)
        //orderBy()で並べ方の指定
        //ASC=昇順、DESC=降順
        ->orderBy('updated_at', 'DESC')
        ->get();

        return view(
            'create',
            ['memos' => $memos, 'user' => $user]
        );
    }

    public function store(Request $request)
    {
        $data = $request->all();
         //dd($data);
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す

        // 同じタグがあるか確認
        //$exist_tag = Tag::where('name', $data['tag'])->where('user_id', $data['user_id'])->first();
        //if( empty($exist_tag['id']) ){
            //先にタグをインサート
            //$tag_id = Tag::insertGetId(['name' => $data['tag'], 'user_id' => $data['user_id']]);
        //}else{
            //$tag_id = $exist_tag['id'];
        //}

        //タグのIDが判明する
        // タグIDをmemosテーブルに入れてあげる
        $memo_id = Memo::insertGetId([
            'content' => $data['content'],
             'user_id' => $data['user_id'], 
             //'tag_id' => $tag_id,
             'status' => 1
        ]);
        
        // リダイレクト処理
        return redirect()->route('home');
    }
}
