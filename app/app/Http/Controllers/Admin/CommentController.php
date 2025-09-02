<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Post::with('user', 'post')->latest()->get();
        return view('admin.comments.index', compact('comments'));
    }
}
