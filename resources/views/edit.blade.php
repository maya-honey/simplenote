{{-- layouts.appを親ファイルに指定（layouts.appで使えるようになる --}}
{{-- layouts.appをベースに、レンダリングする。--}}
{{-- 呼び出されるのはあくまで、このファイル --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center ml-0 mr-0 h-100">
    <div class="card w-100">
        <div class="card-header d-flex justify-content-between">
            メモ編集
            <form method='POST' action="/delete/{{$memo['id']}}" id='delete-form'>
                @csrf
                <button class='p-0 mr-2' style='border:none;'><i id='delete-button' class="fas fa-trash">delete</i></button>
            </form>  
        </div>
        <div class="card-body">
            {{-- route()関数でもルートの指定ができる。↓では第一引数に名前付きルート、第二引数にパラメータを指定している。 --}}
            <form method='POST' action="{{ route('update', ['id' => $memo['id'] ] ) }}">
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                <div class="form-group">
                     <textarea name='content' class="form-control"rows="10">{{ $memo['content'] }}</textarea>
                </div>
                <div class="form-group">
                    <select class='form-control' name='tag_id'>
                @foreach($tags as $tag)
                    <option value="{{ $tag['id'] }}" {{ $tag['id'] == $memo['tag_id'] ? "selected" : "" }}>{{$tag['name']}}</option>
                @endforeach
                    </select>
                </div>
                <button type='submit' class="btn btn-primary btn-lg">更新</button>
            </form>
        </div>
    </div>
</div>
@endsection