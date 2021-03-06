@extends('app')

@section('title', $user->name . 'のいいねした記事 - grfl')

@section('content')
  @include('nav')
  <div class="container">
    @include('users.user')
    @include('users.tabs', ['hasArticles' => false, 'hasLikes' => true])
    @foreach($articles as $article)
      @include('articles.card')
    @endforeach
    @include('users.pagination')
  </div>
  @include('footer')
@endsection
