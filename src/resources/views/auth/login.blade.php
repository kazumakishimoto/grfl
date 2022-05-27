@extends('app')

@section('title', 'ログイン - grfl')

@section('content')

    @include('nav')
    <main>
        <div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                @include('error_card_list')
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                                    <button class="btn btn-success">
                                        <a href="{{ route('login.guest') }}" class="text-white">ゲストログイン</a>
                                    </button>
                                </div>
                                <div>
                                    <a href="{{ route('login.{provider}', ['provider' => 'google']) }}" class="btn btn-block btn-danger mb-4 col-lg-8 col-md-9 col-sm-10 col-xs-12"><i class="fab fa-google mr-1"></i>Googleでログイン</a>
                                </div>
                                {{-- <div>
                                    <a href="{{ route('login.{provider}', ['provider' => 'twitter']) }}" class="btn btn-block btn-info mb-4 col-lg-8 col-md-9 col-sm-10 col-xs-12"><i class="fab fa-twitter mr-1"></i>Twitterでログイン</a>
                                </div> --}}
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </main>
@include('footer')

@endsection
