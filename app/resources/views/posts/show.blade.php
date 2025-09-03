@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- 投稿画像表示 -->
        <div class="col-md-7 d-flex align-items-center justify-content-center bg-dark">
            <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid post-show-img" alt="投稿画像">
        </div>
        <!-- 投稿情報表示 -->
        <div class="col-md-5 d-flex flex-column post-show-right">
            <!-- 投稿情報ヘッダー -->
            <div class="d-flex align-items-center justify-content-between p-3">
                <div class="d-flex align-items-center">
                    <a href="{{ route('profile.show', $post->user_id) }}">
                        <img src="{{ $post->pet ? asset('storage/' . $post->pet->image_path) : asset('storage/' . $post->user->image_path) }}" class="rounded-circle mr-2 icon" alt="ペットアイコン">
                    </a>
                    <a href="{{ route('profile.show', $post->user_id) }}">
                        <strong>{{ $post->pet ? $post->pet->name : $post->user->name }}</strong>
                    </a>
                </div>
                <!-- 自分の投稿ならメニューボタンを表示 -->
                @if($post->user_id === auth()->id())
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
                @endif
            </div>
            <!-- 投稿者・キャプション -->
            <div class="p-3">
                <div class="d-flex align-items-start">
                    <a href="{{ route('profile.show', $post->user_id) }}">
                        <img src="{{ asset('storage/' . $post->user->image_path) }}" class="rounded-circle mr-2 icon" alt="プロフィールアイコン">
                    </a>
                    <div>
                        <a href="{{ route('profile.show', $post->user_id) }}">
                            <strong>{{ $post->user->name }}</strong>
                        </a>
                        <span class="mb-1">{{ $post->caption }}</span>
                        <div><small class="text-muted">{{ $post->created_at->diffForHumans() }}</small></div>
                    </div>
                </div>
            </div>
            <!-- コメント欄 -->
            <div class="p-3">
                @foreach($post->comments()->latest()->get() as $comment)
                    <div class="d-flex align-items-start mb-3">
                        <a href="{{ route('profile.show', $comment->user_id) }}">
                            <img src="{{ asset('storage/' . $comment->user->image_path) }}" class="rounded-circle mr-2 icon" alt="プロフィールアイコン">
                        </a>
                        <div>
                            <a href="{{ route('profile.show', $comment->user_id) }}">
                                <strong>{{ $comment->user->name }}</strong>
                            </a>
                            @if($comment->is_deleted_by_admin)
                                <span class="text-muted"><管理者により削除されました></span>
                            @else
                                <span>{{ $comment->body }}</span>
                            @endif
                            <div><small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- タグ -->
            <div class="mt-auto p-3">
                @foreach($post->tags as $tag)
                    <span class="badge badge-pill badge-light mr-1">#{{ $tag->name }}</span>
                @endforeach
            </div>
            <!-- 足跡・コメント -->
            <div class="p-3">
                <button class="btn btn-link p-0 mr-3 text-muted"><i class="fa-solid fa-paw"></i></button>
                <span class="mr-4">{{ $post->likes_count ?? 0 }}</span>

                <button class="btn btn-link p-0 mr-3 text-white"><i class="bi bi-chat"></i></button>
                <span>{{ $post->comments->count() }}</span>
            </div>
            <div class="p-3 text-muted">
                {{ $post->created_at->format('Y年m月d日') }}
            </div>
            <div class="p-3">
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="d-flex comment-form">
                    @csrf
                    <input type="text" name="comment" class="form-control mr-2 flex-grow-1" placeholder="コメントを追加...">
                    <button type="submit" class="btn btn-primary flex-shrink-0">投稿する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
