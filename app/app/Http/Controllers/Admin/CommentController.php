<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user', 'post')->latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->is_deleted_by_admin = true;
        $comment->deleted_at_by_admin = now();
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'コメントを削除しました');
    }

    public function restore($id)
    {
        $comment = Comment::findOrFail($id);

        if($comment->is_deleted_by_admin) {
            $comment->is_deleted_by_admin = false;
            $comment->save();
        }

        return redirect()->route('admin.comments.index')->with('success', 'コメントを復元しました');
    }

    public function forceDelete($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->is_deleted_by_admin) {
            $comment->delete();
            return redirect()->route('admin.comments.index')->with('success', 'コメントを完全に削除しました');
        }

        return redirect()->back()->with('error', '削除されていないコメントは完全削除できません');
    }
}
