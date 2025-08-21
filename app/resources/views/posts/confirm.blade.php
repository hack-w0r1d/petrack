@extends('layouts.main')

@section('content')
<img src="{{ asset('storage/' . $imagePath) }}" class="upload-preview" alt="アップロード画像">
<p>ペット： </p>
<p>カテゴリー： </p>
<p>キャプション： {{ $caption }}</p>

<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success">投稿する</button>
</form>
@endsection
