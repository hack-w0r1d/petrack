<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $profile)
    {
        // 編集権限確認
        if ($profile->id !== auth()->id()) {
            abort(403, 'プロフィールを編集する権限がありません');
        }

        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:300',
        ]);

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($profile->image_path && Storage::disk('public')->exists($profile->image_path)) {
                Storage::disk('public')->delete($profile->image_path);
            }
            // 新しい画像を保存
            $path = $request->file('image')->store('uploads/users', 'public');
            $validated['image_path'] = $path;
        }

        $profile->update($validated);

        return redirect()->route('profile.show', Auth::id())->with('success', 'ペット情報を更新しました！');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
