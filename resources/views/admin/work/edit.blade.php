{{-- layouts/work.blade.phpを読み込む（継承） --}}
@extends('layouts.work')

{{-- work.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', '職務経歴の編集')

{{-- work.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>職務経歴の編集</h2>
            </div>
        </div>
    </div>
@endsection