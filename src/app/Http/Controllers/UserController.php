<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Article;

class UserController extends Controller
{
    public function show(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load(['articles.user', 'articles.likes', 'articles.tags']);

        $articles = $user->articles()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    public function likes(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load(['likes.user', 'likes.likes', 'likes.tags']);

        $articles = $user->likes()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.likes', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    public function followings(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load('followings.followers');

        $followings = $user->followings()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('users.followings', [
            'user' => $user,
            'followings' => $followings,
        ]);
    }

    public function followers(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load('followers.followers');

        $followers = $user->followers()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('users.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    public function follow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }

    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }

    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, string $name)
    {
        $user = User::where('name', $name)->first();

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);
        $all_request = $request->all();

        // 画像アップロード
        if (request('avatar')) {
            $image = $request->file('avatar');
            if (app()->isLocal() || app()->runningUnitTests()) {
                // 開発環境
                $path = $image->storeAs('public/images', $user->id . '.jpg');
                $user->avatar = Storage::url($path);
                // $request->file('avatar')->storeAs('public/images', $image);
            } else {
                // 本番環境
                $path = Storage::disk('s3')->put('/', $image, 'public');
                $user->avatar = Storage::disk('s3')->url($path);
            }
        }

        $user->fill($all_request)->save();
        return redirect()->route('users.show', ["name" => $user->name]);
    }

    //パスワード編集画面
    public function editPassword(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit_password', ['user' => $user]);
    }

    //パスワード編集処理
    public function updatePassword(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        //現在のパスワードが合っているかチェック
        if (!(Hash::check($request->current_password, $user->password))) {
            return redirect()->back()
                ->withInput()->withErrors(['current_password' => '現在のパスワードが違います']);
        }

        //現在のパスワードと新しいパスワードが違うかチェック
        if ($request->current_password === $request->password) {
            return redirect()->back()
                ->withInput()->withErrors(['password' => '現在のパスワードと新しいパスワードが変わっていません']);
        }

        $this->passwordValidator($request->all())->validate();

        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('users.show', ["name" => $user->name]);
    }

    public function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function destroy(string $name)
    {
        $user = User::where('name', $name)->first();
        // UserPolicyのdeleteメソッドでアクセス制限
        $this->authorize('delete', $user);
        $user->delete();
        Auth::logout();
        return redirect()->route('articles.index');

        // return $this->resigned($request, $user)
        //     ?: redirect($this->redirectPath());
        // return redirect()->route('articles.index');
    }
}
