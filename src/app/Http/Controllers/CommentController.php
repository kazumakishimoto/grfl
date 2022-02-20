<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Comment\CommentServiceInterface;
use Illuminate\Http\RedirectResponse;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        // ログインしていなかったらログインページに遷移する（この処理を消すとログインしなくてもページを表示する）
        $this->middleware('auth');
    }

    public function store(CommentRequest $request,Comment $comments)
    {
        $comments->fill($request->all());
        // $comments->article_id = $request->article_id;
        // $comments->user_id = $request->user()->id;
        $comments->save();

        return back();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back();
    }
}
