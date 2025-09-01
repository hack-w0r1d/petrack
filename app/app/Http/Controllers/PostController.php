<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Pet;
use App\Tag;

class PostController extends Controller
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
        return view('posts.create');
    }

    public function createDetail(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|max:2048',
        ]);

        $image = $request->file('image');
        $path = $image->store('temp', 'public');

        session(['temp_image' => $path]);

        return redirect()->route('posts.create.detail');
    }

    public function showCreateDetail()
    {
        $imagePath = session('temp_image');
        $pets = Auth::user()->pets;
        $tags = Tag::all();

        return view('posts.create_detail', compact('imagePath', 'pets', 'tags'));
    }

    public function createConfirm(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'nullable|exists:pets,id',
            'tags' => 'nullable|array|max:3',
            'tags.*' => 'integer|exists:tags,id',
            'caption' => 'nullable|string|max:300',
        ]);

        $tagIds = collect($validated['tags'] ?? [])->map(fn($id) => (int)$id)->unique()->take(3)->values()->all();

        $tags = Tag::whereIn('id', $tagIds)->get();

        session([
            'pet_id' => $validated['pet_id'] ?? null,
            'tags' => $tags,
            'caption' => $validated['caption'] ?? '',
        ]);

        return redirect()->route('posts.create.confirm');
    }

    public function showCreateConfirm()
    {

        $imagePath = session('temp_image');
        $pet = Pet::find(session('pet_id'));
        $tags = session('tags');
        $caption = session('caption');

        return view('posts.confirm', compact('imagePath', 'pet', 'tags', 'caption'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $tempPath = session('temp_image');
        $petId = session('pet_id');
        $tags = session('tags');
        $caption = session('caption');

        if (!$tempPath) {
            return redirect()->route('posts.create')->withErrors('画像が見つかりません');
        }

        $filename = basename($tempPath);
        $newPath = 'uploads/posts/' . $filename;
        Storage::disk('public')->move($tempPath, $newPath);

        $post = new Post();
        $post->user_id = auth()->id();
        $post->image_path = $newPath;
        $post->pet_id = $petId;
        $post->caption = $caption;
        $post->save();

        $post->tags()->sync($tags);

        session()->forget(['temp_image', 'pet_id', 'caption']);

        return redirect()->route('home')->with('success', '投稿が完了しました！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);  // 自身の投稿以外は403エラー
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);  // 自身の投稿以外は403エラー
        $post->delete();
        return redirect()->route('home');
    }

    public function explore()
    {
        $posts = Post::latest()->get();
        return view('posts.explore', compact('posts'));
    }
}
