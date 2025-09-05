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
        if (!$post->likes()->where('user_id', Auth::id())->exists()) {
            $post->likes()->create([
                'user_id' => Auth::id(),
            ]);
        }

        return response()->json([
            'status' => 'liked',
            'likes_count' => $post->likes()->count(),
        ]);
    }

    public function destroy(Post $post)
    {
        $post->likes()->where('user_id', Auth::id())->delete();

        return response()->json([
            'status' => 'unliked',
            'likes_count' => $post->likes()->count(),
        ]);
    }
}
