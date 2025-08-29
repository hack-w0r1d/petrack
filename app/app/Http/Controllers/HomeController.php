<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $followingsIds = Auth::user()->followings()->pluck('users.id');

        $posts = Post::whereIn('user_id', $followingsIds)->orWhere('user_id', Auth::id())->latest()->get();
        // $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        return view('home', compact('posts'));
    }
}
