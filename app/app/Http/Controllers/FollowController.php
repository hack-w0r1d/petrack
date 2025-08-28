<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class FollowController extends Controller
{
    public function store($userId)
    {
        $user = Auth::user();

        if ($user->id == $userId) {
            return back()->with('error', '自分自身はフォローできません');
        }

        if (! $user->isFollowing($userId)) {
            $user->followings()->attach($userId);
        }

        return back();
    }

    public function destroy($userId)
    {
        $user = Auth::user();

        $user->followings()->detach($userId);

        return back();
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);

        $followings = $user->followings->sortByDesc('pivot.created_at');

        return view('followings', compact('user', 'followings'));
    }

    public function followers($id)
    {
        return view('followers');
    }
}
