@extends('app')

@section('title', 'お問い合わせ - grfl -')

@section('content')

    @include('nav')
    <header>
    <div>
        <div class="container" style="max-width: 900px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white small pl-0 mb-0">
                    <li class="breadcrumb-item">
                        <a href="/" class="text-teal1">grfl</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        お問い合わせ
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</header>

    <main>
        <div class="bg-paper my-3">
            <div class="container p-0" style="max-width: 540px">
                <h4 class="text-center">
                    お問い合わせ
                </h4>
                <p style="font-size: 14px;">
                    grflに対するご意見・ご感想・お問い合わせなどございましたらお聞かせください。<br>
                    お送りいただいた内容はすべて確認しておりますが、ご返信を差し上げることができない場合もございますので、ご了承ください。
                </p>
                @if (session('status'))
                    <div class="card-text alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        @include('error_card_list')
                        <form method="post" action="{{ route('contact.confirm') }}">
                            @csrf
                            <p class="small">
                                (<span class="text-danger">*</span>は必須項目です)
                            </p>
                            <div class="form-group">
                                <label for="name">お名前</label>
                                <span class="text-danger">*</span>
                                <input class="form-control" type="text" id="name" name="name" required
                                    value="{{ Auth::user()->name ?? old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">メールアドレス</label>
                                <span class="text-danger">*</span>
                                <input class="form-control" type="email" id="email" name="email" required
                                    value="{{ Auth::user()->email ?? old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="title">ご用件</label>
                                <input class="form-control" type="title" id="title" name="title"
                                    value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label for="body">お問い合わせ内容</label>
                                <span class="text-danger">*</span>
                                <textarea type="text" name="body" id="body" rows="5" class="form-control"
                                    required>{{ old('body') }}</textarea>
                                <p class="text-muted small ml-1">1000文字以内</p>
                            </div>
                            <label for="agree" class="small" role="button">
                                <span class="d-flex flex-wrap">
                                    <span>
                                        <input type="checkbox" id="agree" required>
                                        <a href="{{ route('privacy') }}" class="text-teal1 ml-2" target="_blank"
                                            title="プライバシーポリシーをブラウザの別画面で開く">プライバシーポリシー</a>
                                        <span>を確認し、</span>
                                    </span>
                                    <span>同意</span>
                                    <span>
                                        <span>
                                            <span>しました。</span><span class="text-danger">*</span>
                                        </span>
                                    </span>
                                </span>
                            </label>
                            <button type="submit"
                                class="btn btn-block bg-white btn-outline-teal1 text-decoration-none text-teal1 mt-4">
                                <b>送信内容を確認する</b>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('footer')

@endsection
