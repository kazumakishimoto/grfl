<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Models\Tag;
use App\Models\Comment;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index()
    {
        $articles = Article::query()
            ->with(['user', 'likes', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        $prefs = config('pref');
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.create', [
            'allTagNames' => $allTagNames,
        ])->with(['prefs' => $prefs]);
    }

    public function store(ArticleRequest $request, Article $article)
    {
        $article->user_id = $request->user()->id;
        $all_request = $request->all();
        $article->pref_id = $request->pref;

        // 画像アップロード
        if (isset($all_request['image'])) {
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('image', $image, 'public');
            $all_request['image'] = Storage::disk('s3')->url($path);
        }

        $article->fill($all_request)->save();

        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        $prefs = config('pref');
        $tagNames = $article->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.edit', [
            'article' => $article,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ])->with(['prefs' => $prefs]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->user_id = $request->user()->id;
        $all_request = $request->all();
        $article->pref_id = $request->pref;

        // 画像アップロード
        if (isset($all_request['image'])) {
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('image', $image, 'public');
            $all_request['image'] = Storage::disk('s3')->url($path);
        }

        $article->fill($all_request)->save();

        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        $comments = $article->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('articles.show', [
            'article'  => $article,
            'comments' => $comments
        ]);
    }

    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    // 検索機能
    public function search(Request $request)
    {
        $articles = Article::searchFilter($request->search)
        ->prefFilter($request->pref)
        ->orderBy('created_at', 'desc')
        ->with(['user', 'likes', 'tags'])
        ->paginate(10);

        return view('articles.index', [
            'articles' => $articles,
        ]);
    }
}