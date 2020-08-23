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
                <form action="{{ action('Admin\WorkController@update') }}" method="post" enctype="multipart/form-data">

                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="name">職歴・会社名</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="name" value="{{ $form->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="description">詳細</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="description" rows="20">{{ $form->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="file">参考資料</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="file">
                            <div class="form-text text-info">
                                設定中: {{ $form->file }}
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">参考資料を削除
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
                <div class="row mt-5">
                    <div class="col-md-4 mx-auto">
                        <h2>編集履歴</h2>
                        <ul class="list-group">
                            @if ($form->histories != NULL)
                                @foreach ($form->histories as $history)
                                    <li class="list-group-item">{{ $history->edited_at }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection