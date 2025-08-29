<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class FollowController extends Controller
{
    public function follow(User $user)
    {

        // $user = Auth::user();

        if ($user->id == Auth::id()) {
            return back()->with('error', '自分自身はフォローできません');
        } else {
            Auth::user()->followings()->syncWithoutDetaching([$user->id]);
            return response()->json(['success' => true]);
        }

        // if (! $user->isFollowing($userId)) {
        //     $user->followings()->attach($userId);
        // }

        // return back();
    }

    public function unfollow(User $user)
    {

        Auth::user()->followings()->detach($user->id);
        return response()->json(['success' => true]);

        // $user = Auth::user();

        // $user->followings()->detach($user->id);

        // return response()->json(['success' => true]);
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);

        $followings = $user->followings->sortByDesc('pivot.created_at');

        return view('followings', compact('user', 'followings'));
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);

        $followers = $user->followers->sortByDesc('pivot.created_at');

        return view('followers', compact('user', 'followers'));
    }
}
