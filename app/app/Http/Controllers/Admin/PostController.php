<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'with');

        if ($filter === 'only') {
            $posts = Post::onlyTrashed()->latest()->paginate(10);
        } elseif ($filter === 'without') {
            $posts = Post::latest()->paginate(10);
        } else {
            $posts = Post::withTrashed()->latest()->paginate(10);
        }

        return view('admin.posts.index', compact('posts', 'filter'));

        // $posts = Post::with('user')->latest()->paginate(10);
        // return view('admin.posts.index', compact('posts'));
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('delete', '投稿を削除しました');
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->restore();

        return redirect()->route('admin.posts.index')->with('success', '投稿を復元しました');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->forceDelete();

        return redirect()->route('admin.posts.index')->with('error', '投稿を完全に削除しました');
    }
}
