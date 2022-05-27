@extends('app')

@section('title', '記事一覧 - grfl')

@section('content')
@include('nav')
@include('articles.bg-image')
<div class="container">
    @foreach($articles as $article)
    @include('articles.card')
    @endforeach
    @include('articles.pagination')
</div>
@include('footer')
@endsection
