<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Memo;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //bootは全てのメソッドが呼ばれる前に呼ばれるメソッド
        View::composer('*',function($view){
            $user = Auth::user();

            $memoModel = new Memo();
            $memos = $memoModel->myMemo( Auth::id() );

            $tagModel = new Tag();
            $tags = $tagModel
            ->where('user_id', Auth::id())
            ->get();

            $view
            ->with('user', $user)
            ->with('memos', $memos)
            ->with('tags', $tags);
        });
    }
}
