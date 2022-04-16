@foreach ($comments as $comment)
<div class="card mt-3">
    <div class="card-body d-flex flex-row">
        <a href="{{ route('users.show', ['name' => $comment->user->name]) }}" class="text-dark mr-3">
            <img src="{{ $comment->user->avatar }}" class="img-fuild rounded-circle" width="60" height="60">
        </a>
    <div>
        <div class="font-weight-bold">
            <a href="{{ route('users.show', ['name' => $comment->user->name]) }}" class="text-dark">{{ $comment->user->name }}</a>
        </div>
        <div class="font-weight-lighter">{{ $comment->created_at->format('Y/m/d H:i') }}</div>
    </div>

  @if( Auth::id() === $comment->user_id )
    <!-- dropdown -->
      <div class="ml-auto card-text">
        <div class="dropdown">
          <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $comment->id }}">
              <i class="fas fa-trash-alt mr-1"></i>コメントを削除する
            </a>
          </div>
        </div>
      </div>
      <!-- dropdown -->

      <!-- modal -->
      <div id="modal-delete-{{ $comment->id }}" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="{{ route('comments.destroy', ['comment' => $comment]) }}">
              @csrf
              @method('DELETE')
              <div class="modal-body">
                {{ $comment->comment }}を削除します。よろしいですか？
              </div>
              <div class="modal-footer justify-content-between">
                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                <button type="submit" class="btn btn-danger">削除する</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- modal -->
    @endif

  </div>
  <div class="card-body pt-0">
    <div class="card-text">
      {!! nl2br(e( $comment->comment )) !!}
    </div>
  </div>
</div>
@endforeach
