<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Like;

class LikeController extends Controller
{
    // いいね（足跡）登録
    public function store(Post $post)
    {
        $post->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'いいねしました',
            'likes_count' => $post->likes()->count(),
        ]);
    }

    public function destroy(Post $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();

        return response()->json([
            'message' => 'いいねを解除しました',
            'likes_count' => $post->likes()->count(),
        ]);
    }
}
