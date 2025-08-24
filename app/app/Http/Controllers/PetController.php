<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pet;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
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
        return view('pets.form', ['pet' => new Pet()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
            'gender' => 'nullable|in:1, 2',
            'birthday' =>'nullable|date',
            'species' => 'nullable|string|max:50',
            'breed' => 'nullable|string|max:50'
        ]);
        // 画像保存
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/pets', 'public');
        }
        // DBに保存
        $request->user()->pets()->create([
            'name' =>$validated['name'],
            'image_path' =>$path,
            'gender' =>$validated['gender'] ?? null,
            'birthday' =>$validated['birthday'] ?? null,
            'species' =>$validated['species'] ?? null,
            'breed' =>$validated['breed'],
        ]);

        return redirect()->route('profile.show', auth()->id())->with('success', 'ペット情報を登録しました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        // 編集権限確認
        if ($pet->user_id !== auth()->id()) {
            abort(403, 'このペットを編集する権限がありません');
        }

        return view('pets.form', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        // 編集権限確認
        if ($pet->user_id !== auth()->id()) {
            abort(403, 'このペットを編集する権限がありません');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
            'gender' => 'nullable|in:1, 2',
            'birthday' =>'nullable|date',
            'species' => 'nullable|string|max:50',
            'breed' => 'nullable|string|max:50'
        ]);

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($pet->image_path && Storage::disk('public')->exists($pet->image_path)) {
                Storage::disk('public')->delete($pet->image_path);
            }
            // 新しい画像を保存
            $path = $request->file('image')->store('uploads/pets', 'public');
            $validated['image_path'] = $path;
        }

        $pet->update($validated);

        return redirect()->route('profile.show', auth()->id())->with('success', 'ペット情報を更新しました！');
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
