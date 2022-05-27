@extends('app')

@section('title', 'パスワード編集 - grfl')

@section('content')
  @include('nav')
  <div class="container">
      <div class="row">
        <div class="mx-auto col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6 my-5">
            <div class="card mt-5">
                <div class="card-body text-center">
                    <h2 class='h4 card-title text-center mt-5 mb-1'><span class="bg cyan darken-3 text-white py-3 px-4 rounded-pill">パスワード変更</span></h2>
                    <p class="mt-4">Password Edit</p>

                    @if (Auth::id() == config('user.guest_user.id'))
                    <div class="card-body text-center">
                        <p class="text-danger">
                            <b>※ゲストユーザーは、パスワードを編集できません。</b>
                        </p>
                    </div>
                    @endif

                    @include('error_card_list')

                    <div class="card-text mt-5">
                        <form method="POST" action="{{ route('users.password.update', ['name' => $user->name]) }}">
                            @method('PATCH')
                            @csrf

                            <div class="md-form col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3">
                                <label for="old_password">現在のパスワード</label>
                                @if (Auth::id() == config('user.guest_user.id'))
                                <input type="password" class="form-control" id="old_password" name="current_password" required readonly>
                                @else
                                <input type="password" class="form-control" id="old_password" name="current_password" required>
                                @endif
                                <small>ご登録のパスワードを入力ください</small>
                            </div>
                            <div class="md-form col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3">
                                <label for="password">新しいパスワード</label>
                                @if (Auth::id() == config('user.guest_user.id'))
                                <input type="password" class="form-control" id="password" name="password" required readonly>
                                @else
                                <input type="password" class="form-control" id="password" name="password" required>
                                @endif
                                <small>8文字以上で入力してください</small>
                            </div>
                            <div class="md-form col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-3">
                                <label for="password_confirmation">新しいパスワード（確認）</label>
                                @if (Auth::id() == config('user.guest_user.id'))
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required readonly>
                                @else
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                @endif
                                <small>パスワードを再入力してください</small>
                            </div>
                            <button class="btn btn-block cyan darken-3 text-white col-lg-8 col-md-9 col-sm-10 col-xs-12 mx-auto mt-4 mb-5" type="submit">
                                変更する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  @include('footer')
@endsection
