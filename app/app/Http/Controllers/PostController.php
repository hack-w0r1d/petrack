<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function edit(Post $post)
    {
        $this->authorize('update', $post);  // 自身の投稿以外は403エラー
        return view('');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);  // 自身の投稿以外は403エラー
        // $post->delete();
        return redirect()->route('');
    }
}
