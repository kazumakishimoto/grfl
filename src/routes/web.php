<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# ユーザー新規登録、ログイン、ログアウト
Auth::routes();

# ゲストユーザーログイン
Route::get('guest', 'Auth\LoginController@guestLogin')->name('login.guest');

# SNSアカウントログイン
Route::prefix('login')->name('login.')->group(function () {
    Route::get('/{provider}', 'Auth\LoginController@redirectToProvider')->name('{provider}');
    Route::get('/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('{provider}.callback');
});
# SNSアカウントユーザー登録
Route::prefix('register')->name('register.')->group(function () {
    Route::get('/{provider}', 'Auth\RegisterController@showProviderUserRegistrationForm')->name('{provider}');
    Route::post('/{provider}', 'Auth\RegisterController@registerProviderUser')->name('{provider}');
});

# フッター
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');
Route::get('/terms', 'HomeController@terms')->name('terms');

# お問い合わせ
// 入力ページ
Route::get('/contact', 'ContactController@index')->name('contact.index');
// 確認ページ
Route::post('/contact/confirm', 'ContactController@confirm')->name('contact.confirm');
// 送信完了ページ
Route::post('/contact/thanks', 'ContactController@send')->name('contact.send');

# ユーザー投稿関係(create, store, edit, update, destroy)
Route::get('/', 'ArticleController@index')->name('articles.index');
Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');
Route::resource('/articles', 'ArticleController')->only(['show']);

# 検索機能
Route::get('/search', 'ArticleController@search')->name('articles.search');

# タグ機能
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');

# ユーザー関係
Route::prefix('users')->name('users.')->group(function () {
    // ユーザー詳細
    Route::get('/{name}', 'UserController@show')->name('show');
    // いいね一覧
    Route::get('/{name}/likes', 'UserController@likes')->name('likes');
    // フォロー一覧
    Route::get('/{name}/followings', 'UserController@followings')->name('followings');
    // フォロワー一覧
    Route::get('/{name}/followers', 'UserController@followers')->name('followers');
});

### ログイン状態で使用可能 ###
Route::middleware('auth')->group(function () {
    Route::prefix('users/{name}')->name('users.')->group(function () {
        // プロフィール編集
        Route::get('/edit', 'UserController@edit')->name('edit');
        // プロフィール更新
        Route::patch('/update', 'UserController@update')->name('update');
        // ユーザー削除
        Route::delete('/destroy', 'UserController@destroy')->name('destroy');
        // パスワード編集
        Route::get('/password/edit', 'UserController@editPassword')->name('password.edit');
        // パスワード更新
        Route::patch('/password/update', 'UserController@updatePassword')->name('password.update');
        // フォロー機能
        Route::put('/follow', 'UserController@follow')->name('follow');
        Route::delete('/follow', 'UserController@unfollow')->name('unfollow');
    });

    # いいね機能
    Route::prefix('articles')->name('articles.')->group(function () {
        Route::put('/{article}/like', 'ArticleController@like')->name('like');
        Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike');
    });

    # コメント投稿関係(store, destroy)
    Route::resource('/comments', 'CommentController')->only(['store', 'destroy']);
});
