<ul>
  @forelse ($article->comments as $comment)
  <li>{{ $comment->comment }}</li>
  @empty
  <li>No comment yet</li>
  @endforelse
</ul>

{{-- @foreach ($comments as $comment)
  <div class="mb-2">
    @if ($comment->user->id == Auth::user()->id)
      <a class="delete-comment" data-remote="true" rel="nofollow" data-method="delete" href="/comments/{{ $comment->id }}"></a>
    @endif
    <span>
      <strong>
        <a class="no-text-decoration black-color" href="/users/{{ $comment->user->id }}">{{ $comment->user->name }}</a>
      </strong>
    </span>
    <span>{{ $comment->comment }}</span>
  </div>
@endforeach --}}
