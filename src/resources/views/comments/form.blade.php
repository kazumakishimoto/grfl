<form method="POST" action="{{ route('comments.store') }}">
    @csrf
    <p>
        <input value="{{ $article->id }}" type="hidden" name="article_id" />
        <input value="{{ Auth::id() }}" type="hidden" name="user_id" />
        <input type="text" name="comment" placeholder="comment" value="{{ old('comment') }}">
        @if ($errors->has('comment'))
        <span class="error">{{ $errors->first('comment') }}</span>
        @endif
    </p>
    <p>
        <input type="submit" value="Add Comment">
    </p>
</form>
