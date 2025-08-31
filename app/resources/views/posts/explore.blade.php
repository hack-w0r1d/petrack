@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        @foreach($posts as $post)
            <div class="col-4 mb-3">
                <a href="{{ route('posts.show', $post->id) }}">
                    <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid" alt="投稿画像">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
