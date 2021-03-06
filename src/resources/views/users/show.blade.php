@extends('app')

@section('title', $user->name . '- grfl')

@section('content')
  @include('nav')
  <div class="container">
      @include('users.user')
      @include('users.tabs', ['hasArticles' => true, 'hasLikes' => false])
    @foreach($articles as $article)
      @include('articles.card')
    @endforeach
    @include('users.pagination')
  </div>
  @include('footer')
@endsection
