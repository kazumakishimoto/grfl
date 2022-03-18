@extends('app')

@section('title', 'プロフィール編集')

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">プロフィール編集</span></h2>
                    <p class="mt-4">Profile Edit</p>
                </div>
                @if (Auth::id() == config('user.guest_user.id'))
                <div class="card-body text-center">
                    <p class="text-danger">
                        <b>※ゲストユーザーは、以下を編集できません。</b><br>
                        ・アイコン画像<br>
                        ・ユーザー名<br>
                        ・メールアドレス<br>
                    </p>
                </div>
                @endif
                @include('error_card_list')
                <div class="mt-2">
                        <div class="card-body align-items-center text-center mt-2 mb-3">
                            <form action="{{ route('users.update', ['name' => $user->name]) }}" method="POST" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                {{-- 編集フォーム --}}
                                @if(Auth::id() != config('user.guest_user.id'))
                                <label for="avatar">
                                    <img src="{{ asset('storage/avatar/'.$user->avatar) }}" id="img" class="img-fuild rounded-circle" width="80" height="80">
                                    <input type="file" id="avatar" name="avatar" onchange="previewImage(this);" class="d-none">
                                </label>
                                @endif
                                <div class="md-form col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto">
                                    <label for="name">ユーザー名</label>
                                    @if (Auth::id() == config('user.guest_user.id'))
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name }}" readonly>
                                    @else
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ $user->name ?? old('name') }}">
                                    @endif
                                    <small>3〜15文字で入力してください</small>
                                </div>
                                <div class="md-form col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto">
                                    <label for="age">年齢</label>
                                    <input type="text" class="form-control" id="age" name="age" value="{{ $user->age ?? old('age') }}">
                                </div>
                                <div class="md-form col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto">
                                    <label for="introduction">自己紹介</label>
                                    <input type="text" class="form-control" id="introduction" name="introduction" value="{{ $user->introduction ?? old('introduction') }}" >
                                </div>
                                <div class="md-form col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto">
                                    <label for="email">メールアドレス</label>
                                    @if (Auth::id() == config('user.guest_user.id'))
                                    <input type="text" class="form-control" id="email" name="email" required value="{{ $user->email }}" readonly>
                                    @else
                                    <input type="text" class="form-control" id="email" name="email" required value="{{ $user->email ?? old('email') }}">
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-block cyan darken-3 text-white col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mt-5 waves-effect">
                                    更新する
                                </button>

                                {{-- パスワード変更 --}}
                                <div class="mx-auto">
                                    <a class='btn btn-amber col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mt-3 waves-effect waves-effect' href="{{ route('users.password.edit', ['name' => $user->name]) }}">パスワード変更はこちら</a>
                                </div>
                            </form>

                            {{-- ユーザー消去 --}}
                            @if(Auth::id() != config('user.guest_user.id'))
                            <div class="mx-auto">
                                <a class="btn btn-danger col-lg-6 col-md-7 col-sm-8 col-xs-10 mx-auto mt-3 mb-5 waves-effect" data-toggle="modal" data-target="#modal-delete-{{ $user->id }}">退会する</a>
                            </div>
                            <div id="modal-delete-{{ $user->id }}" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('users.destroy', ['name' => $user->name]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <div class="modal-body">{{ $user->name }} 様が退会します。よろしいですか？</div>
                                            <div class="modal-footer justify-content-between">
                                                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                                                <button type="submit" class="btn btn-danger">退会する</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('footer')
@endsection
