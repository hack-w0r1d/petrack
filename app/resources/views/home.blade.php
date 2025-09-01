@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <!-- 投稿一覧 -->
        <div class="col-md-7 offset-md-1 pt-4">
            <div class="post-wrapper mx-auto">
                @forelse ($posts as $post)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.show', $post->user->id) }}">
                                    <img src="{{ asset('storage/' . $post->user->image_path) }}" class="rounded-circle icon" alt="プロフィール画像">
                                </a>
                                <div class="ml-2">
                                    <a href="{{ route('profile.show', $post->user->id) }}">
                                        <div class="font-weight-bold">{{ $post->user->name }}</div>
                                    </a>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-toggle" type="button" id="postMenu{{ $post->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-three-dots" style="color: white; font-size: 1.3rem"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="postMenu{{ $post->id }}">
                                    <a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">編集</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- 投稿画像 -->
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top post-img" alt="投稿画像">
                        <!-- 足跡・コメント -->
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <button class="btn btn-link p-0 mr-3 text-muted"><i class="fa-solid fa-paw"></i></button>
                                <span class="mr-4">{{ $post->likes_count ?? 0 }}</span>

                                <button class="btn btn-link p-0 mr-3 text-white">
                                    <a href="{{ route('posts.show', $post->id) }}"><i class="bi bi-chat"></i></a>
                                </button>
                                <span>{{ $post->comments->count() }}</span>
                            </div>

                            <p class="mb-1">
                                <span class="font-weight-bold mr-2">
                                    <a href="{{ route('profile.show', $post->user->id) }}">{{ $post->user->name }}</a>
                                </span>
                                {{ $post->caption }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center" style="font-size: 1.5vw;">
                        <p>投稿がありません</p>
                        <p>お気に入りのユーザーを見つけてフォローしてみよう</p>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- おすすめ(仮) -->
        <div class="col-md-4 pt-4">
            <div class="d-flex align-items-center">
                <a href="{{ route('profile.show', ['profile' => Auth::user()->id]) }}">
                    <img src="{{ asset('storage/' . auth()->user()->image_path) }}" class="rounded-circle mr-2" width="40" height="40" alt="プロフィール画像">
                </a>
                <a class="ml-2" href="{{ route('profile.show', ['profile' => Auth::user()->id]) }}">
                    <div>
                        <div class="text-white font-weight-bold">{{ Auth::user()->name }}</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- <div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    ログインしました！
</div> -->
