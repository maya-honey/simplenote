{{-- layouts.appを親ファイルに指定（layouts.appで使えるようになる --}}
{{-- layouts.appをベースに、レンダリングする。--}}
{{-- 呼び出されるのはあくまで、このファイル --}}
@extends('layouts.app')

{{-- @section('名前')で表示する範囲を指定 --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
