<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Comment\CommentServiceInterface;
use Illuminate\Http\RedirectResponse;
// use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        // ログインしていなかったらログインページに遷移する（この処理を消すとログインしなくてもページを表示する）
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $comments = new Comment();
        $comments->comment = $request->comment;
        $comments->article_id = $request->article_id;
        $comments->user_id = Auth::user()->id;
        $comments->save();

        return redirect('/');
    }

    public function destroy(Request $request)
    {
        $comments = Comment::find($request->comment_id);
        $comments->delete();
        return redirect('/');
    }
}
