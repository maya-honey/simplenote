{{-- layouts.appを親ファイルに指定（layouts.appで使えるようになる --}}
{{-- layouts.appをベースに、レンダリングする。--}}
{{-- 呼び出されるのはあくまで、このファイル --}}
@extends('layouts.app')

{{-- @section('名前')で表示する範囲を指定 --}}
@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    {{$user['name']}}
    <div class="card w-100">
        <div class="card-header">新規メモ作成</div>
        <div class="card-body">
            <form method='POST' action="/store">
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                <div class="form-group">
                     <textarea name='content' class="form-control"rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="tag">タグ</label>
                    <input type="text" name='tag' class="form-control" id='tag' placeholder="タグを入力">
                </div>
                
                <button type='submit' class="btn btn-primary btn-lg">保存</button>
            </form>
        </div>
    </div>
</div>
@endsection
