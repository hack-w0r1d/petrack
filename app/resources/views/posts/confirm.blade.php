@extends('layouts.main')

@section('content')
<img src="{{ asset('storage/' . $imagePath) }}" class="upload-preview" alt="アップロード画像">
<p>ペット名： {{ $pet->name }}</p>
<p>カテゴリー：
    @foreach($tags as $tag)
        <span class="tag-label mr-2" style="background-color: #007bff; color: #fff;">{{ $tag->name }}</span>
    @endforeach
</p>
<p>キャプション： {{ $caption }}</p>

<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success">投稿する</button>
</form>
@endsection
