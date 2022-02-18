@extends('app')

@section('title', '記事詳細')

@section('content')
  @include('nav')
  <div class="container">
    @include('articles.card')
    @auth
    @include('comments.form')
    @endauth
    @include('comments.card')
  </div>
@endsection
