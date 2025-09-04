@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="my-4 text-center">検索</h2>

    <form action="#" method="GET">
        <div class="form-group">
            <label for="species">種（例：犬、猫）</label>
            <input type="text" name="species" class="form-control" value="{{ request('species') }}">
        </div>

        <div class="form-group">
            <label for="breed">品種（例：プードル、スコティッシュ）</label>
            <input type="text" name="breed" class="form-control" value="{{ request('breed') }}">
        </div>

        <button type="submit" class="btn btn-primary mt-2">検索</button>
    </form>

    @if(!$request->filled('species') && !$request->filled('breed'))
        <p class="mt-4 text-center text-muted">条件を入力してください</p>
    @elseif($posts->isEmpty())
        <p class="mt-4 text-center text-muted">条件に一致する投稿がありません</p>
    @else
        <div class="row mt-4">
            @foreach($posts as $post)
                <div class="col-md-4 mb-3">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid" alt="投稿画像">
                    </a>
                </div>
            @endforeach
        </div>
    @endif
    <div class="d-flex justify-content-center">
        {{ $posts->appends(request()->query())->links() }}
    </div>
</div>
@endsection
