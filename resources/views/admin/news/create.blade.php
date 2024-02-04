@extends('layouts.admin')
@section('title', 'ニュースの新規作成')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>ニュース新規作成</h2>
            <form action="{{ route('news.create') }}" method="post" enctype="multipart/form-data">
                <div class="form-group row mb-2">
                    <label class="col-md-2" for="title">タイトル</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-md-2" for="body">本文</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-md-2" for="title">画像</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="image">
                    </div>
                </div>
                {{ csrf_field() }}
                <input type="submit" class="btn btn-primary" value="登録">
            </form>
        </div>
    </div>
</div>
@endsection