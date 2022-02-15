<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Article;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //プロフィール編集画面
    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //プロフィール編集処理
    public function update(UserRequest $request, string $name)
    {
        $user = User::where('name', $name)->first();
        $all_request = $request->all();

        // if (isset($all_request['avatar'])) {
        //     $avatar = $request->file('avatar');
        //     $upload_info = Storage::disk('s3')->putFile('avatar', $avatar, 'public');
        //     $all_request['avatar'] = Storage::disk('s3')->url($upload_info);
        //     $user->fill($all_request)->save();
        // }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $name)
    {
        DB::transaction(function () use ($name) {
            $user = $this->userService->delete($name);

            // UserPolicyのdeleteメソッドでアクセス制限
            $this->authorize('delete', $user);
        });

        toastr()->success('退会処理が完了しました');

        return redirect()->route('articles.index');
    }
}
