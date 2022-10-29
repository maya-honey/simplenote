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
        return view('create');
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
         
        // POSTされたデータをDB（memosテーブル）に挿入
        // MEMOモデルにDBへ保存する命令を出す

        // 同じタグがあるか確認
        $exist_tag = Tag::where('name', $data['tag'])
        ->where('user_id', $data['user_id'])
        ->first();
        
        if( empty($exist_tag['id']) ){
            //先にタグをインサート
            $tag_id = Tag::insertGetId([
                'name' => $data['tag'],
                'user_id' => $data['user_id']
            ]);
        }else{
            $tag_id = $exist_tag['id'];
        }

        //タグのIDが判明する
        // タグIDをmemosテーブルに入れてあげる
        $memo_id = Memo::insertGetId([
            'content' => $data['content'],
             'user_id' => $data['user_id'], 
             'tag_id' => $tag_id,
             'status' => 1
        ]);
        
        // リダイレクト処理
        return redirect()->route('home');
    }

    public function edit($memo_id)
    {
        $user = Auth::user();
        
        $memo = Memo::where('id', $memo_id)
        ->where('user_id', $user['id'])
        ->first();

        return view('edit', ['memo' => $memo]);
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->all();

        Memo::where('id', $id)
        ->update([
            'content' => $inputs['content'],
            'tag_id' => $inputs['tag_id']
        ]);

        return redirect()->route('home');
    }

    public function delete(Request $request, $id)
    {
        $inputs = $request->all();
        
        //論理削除
        Memo::where('id', $id)->update(['status' => 2]);
        
        return redirect()->route('home')->with('success', 'メモの削除が完了しました！');
    }
}
