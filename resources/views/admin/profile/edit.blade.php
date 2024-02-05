@extends('layouts.profile')
@section('title', 'Myプロフィール')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>Myプロフィール編集</h2>
            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                @if (count($errors) > 0)
                <ul>
                    @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                    @endforeach
                </ul>
                @endif
                <div class="form-group row mb-2">
                    <label class="col-md-2" for="name">名前</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="name" value="{{ $profile_form->name }}">
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-md-2" for="gender">性別</label>
                    <div class="col-md-10">

                        <div class="form-check form-check-inline">
                            <input type="radio" name="gender" id="男性" value="男性" {{ $profile_form->gender == '男性' ? 'checked' : '' }}>男性
                        </div><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="gender" id="女性" value="女性" {{ $profile_form->gender == '女性' ? 'checked' : '' }}>女性
                        </div><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="gender" id="不明" value="不明" {{ $profile_form->gender == '不明' ? 'checked' : '' }}>不明
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-md-2" for="hobby">趣味</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="hobby" rows="10">{{ $profile_form->hobby }}</textarea>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-md-2" for="introduction">自己紹介欄</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="introduction" rows="10">{{ $profile_form->introduction }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        <input type="hidden" name="id" value="{{ $profile_form->id }}">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="更新">
                    </div>
                </div>
            </form>
            <div class="row mt-5">
                <div class="col-md-4 mx-auto">
                    <h2>編集履歴</h2>
                    <ul class="list-group">
                        @if ($profile_form->profilehistories != NULL)
                        @foreach ($profile_form->profilehistories as $history)
                        <li class="list-group-item text-white">{{ $history->edited_at }}</li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection