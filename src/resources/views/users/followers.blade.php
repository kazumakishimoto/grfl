@extends('app')

@section('title', $user->name . 'のフォロワー - grfl')

@section('content')
  @include('nav')
  <div class="container">
    @include('users.user')
    @include('users.tabs', ['hasArticles' => false, 'hasLikes' => false])
    @foreach($followers as $person)
      @include('users.person')
    @endforeach
    {{ $followers->links('pagination::default') }}
  </div>
  @include('footer')
@endsection
