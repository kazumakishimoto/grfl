@extends('app')

@section('title', 'お問い合わせ内容の確認 - grfl')

@section('content')

    @include('nav')

    <main>
        <div class="bg-paper my-3">
            <div class="container p-0" style="max-width: 540px">
                <h4 class="text-center">
                    お問い合わせ内容の確認
                </h4>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form method="post" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="text-muted">
                                    お名前
                                </label>
                                <p>
                                    {{ $inputs['name'] }}
                                </p>
                                <input name="name" value="{{ $inputs['name'] }}" type="hidden">
                            </div>
                            <div class="form-group">
                                <label for="email" class="text-muted">
                                    メールアドレス
                                </label>
                                <p>
                                    {{ $inputs['email'] }}
                                </p>
                                <input name="email" value="{{ $inputs['email'] }}" type="hidden">
                            </div>
                            <div class="form-group">
                                <label for="title" class="text-muted">
                                    ご用件
                                </label>
                                <p>
                                    @if ($inputs['title'] !== null)
                                        {{ $inputs['title'] }}
                                    @else
                                        無題
                                    @endif
                                </p>
                                <input name="title" value="{{ $inputs['title'] }}" type="hidden">
                            </div>
                            <div class="form-group">
                                <label for="body" class="text-muted">
                                    お問い合わせ内容
                                </label>
                                <p>
                                    {!! nl2br(e($inputs['body'], false)) !!}
                                </p>
                                <input name="body" value="{{ $inputs['body'] }}" type="hidden">
                            </div>
                            <button type="submit" name="back" value="back" class="btn btn-block btn-teal1 mt-4">
                                入力内容修正
                            </button>
                            <button type="submit" name="action" value="submit"
                                class="btn btn-block bg-white btn-outline-secondary text-decoration-none text-secondary mt-4">
                                送信する
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('footer')

@endsection
