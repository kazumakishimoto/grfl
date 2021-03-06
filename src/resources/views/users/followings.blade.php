@extends('app')

@section('title', $user->name . 'のフォロー中 - grfl')

@section('content')
  @include('nav')
  <div class="container">
    @include('users.user')
    @include('users.tabs', ['hasArticles' => false, 'hasLikes' => false])
    @foreach($followings as $person)
      @include('users.person')
    @endforeach
    {{ $followings->links('pagination::default') }}
  </div>
  @include('footer')
@endsection
