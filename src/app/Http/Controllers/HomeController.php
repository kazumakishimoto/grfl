<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * サービス概要紹介画面表示
     */
    public function about()
    {
        return view('about');
    }


    /**
     * プライバシーポリシー画面表示
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * 利用規約画面表示
     */
    public function terms()
    {
        return view('terms');
    }
}
