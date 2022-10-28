<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('home');
    }

    public function create()
    {
        //Auht::user()で現在認証しているユーザーを取得
        $user = Auth::user();
        return view(
            'create',
            compact('user')
        );
    }
}
