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
    /*
    |--------------------------------------------------------------------------
    | ユーザーページ表示
    |--------------------------------------------------------------------------
    */
    public function show(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load(['articles.user', 'articles.likes', 'articles.tags']);

        $articles = $user->articles()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'user' => $user,
            'articles' => $articles,
        ];

        return view('users.show', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | プロフィール編集画面
    |--------------------------------------------------------------------------
    */
    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        $data = [
            'user' => $user
        ];

        return view('users.edit', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | プロフィール編集処理
    |--------------------------------------------------------------------------
    */
    public function update(UserRequest $request, string $name)
    {
        $validated = $request->validated();

        $user = User::where('name', $name)->first();

        // 画像アップロード
        if (isset($validated['avatar'])) {
            $image = $request->file('avatar');
            $path = Storage::disk('s3')->putFile('avatar', $image, 'public');
            $validated['avatar'] = Storage::disk('s3')->url($path);
        }

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        // バリデーションにかけた値だけをDBに保存
        $user->fill($validated)->save();

        $data = [
            "name" => $user->name
        ];

        return redirect()->route('users.show', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | ユーザー退会
    |--------------------------------------------------------------------------
    */
    public function destroy(string $name)
    {
        $user = User::where('name', $name)->first();

        // UserPolicyのdeleteメソッドでアクセス制限
        $this->authorize('delete', $user);

        $user->delete();
        Auth::logout();

        return redirect()->route('articles.index');
    }

    /*
    |--------------------------------------------------------------------------
    | いいね一覧画面
    |--------------------------------------------------------------------------
    */
    public function likes(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load(['likes.user', 'likes.likes', 'likes.tags']);

        $articles = $user->likes()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'user' => $user,
            'articles' => $articles,
        ];

        return view('users.likes', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | フォロー一覧画面
    |--------------------------------------------------------------------------
    */
    public function followings(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load('followings.followers');

        $followings = $user->followings()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $data = [
            'user' => $user,
            'followings' => $followings,
        ];

        return view('users.followings', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | フォロワー一覧画面
    |--------------------------------------------------------------------------
    */
    public function followers(string $name)
    {
        $user = User::where('name', $name)->first()
            ->load('followers.followers');

        $followers = $user->followers()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $data = [
            'user' => $user,
            'followers' => $followers,
        ];

        return view('users.followers', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | フォロー機能
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | フォロー解除機能
    |--------------------------------------------------------------------------
    */
    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }

    /*
    |--------------------------------------------------------------------------
    | パスワード編集画面
    |--------------------------------------------------------------------------
    */
    public function editPassword(string $name)
    {
        $user = User::where('name', $name)->first();

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        $data = [
            'user' => $user
        ];

        return view('users.edit_password', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | パスワード編集処理
    |--------------------------------------------------------------------------
    */
    public function updatePassword(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        // 現在のパスワードが合っているかチェック
        if (!(Hash::check($request->current_password, $user->password))) {
            return redirect()->back()
                ->withInput()->withErrors(['current_password' => '現在のパスワードが違います']);
        }

        // 現在のパスワードと新しいパスワードが違うかチェック
        if ($request->current_password === $request->password) {
            return redirect()->back()
                ->withInput()->withErrors(['password' => '現在のパスワードと新しいパスワードが変わっていません']);
        }

        $this->passwordValidator($request->all())->validate();

        $user->password = Hash::make($request->password);
        $user->save();

        $data = [
            "name" => $user->name
        ];

        return redirect()->route('users.show', $data);
    }

    public function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}