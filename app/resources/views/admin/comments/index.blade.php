@extends('layouts.main')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-danger">
            {{ session('success') }}
        </div>
    @endif
    <h2 class="text-center my-4">コメント管理</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>コメント</th>
                <th>日時</th>
                <th>管理者削除ステータス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                <tr>
                    <td>
                        <a href="{{ route('posts.show', $comment->post->id) }}" style="color: #38c172;">
                            {{ $comment->id }}
                        </a>
                    </td>
                    <td>{{ $comment->body }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>
                        @if($comment->is_deleted_by_admin)
                            <span style="color: red;">削除中</span>
                        @endif
                    </td>
                    <td>
                        @if(!$comment->is_deleted_by_admin)
                            <!-- 論理削除ボタン -->
                            <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-warning btn-sm">論理削除</button>
                            </form>
                        @else
                            <div class="d-flex">
                                <!-- 削除取消ボタン -->
                                <form action="{{ route('admin.comments.restore', $comment->id) }}" method="POST" class="mr-2" onsubmit="return confirm('削除を取り消しますか？');">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-primary btn-sm">削除取消</button>
                                </form>
                                <!-- 物理削除ボタン -->
                                <form action="{{ route('admin.comments.forceDelete', $comment->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？この操作は元に戻せません。');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">物理削除</button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $comments->links() }}
    </div>
    <a class="btn btn-primary return-dashboard-btn" href="{{ route('admin.dashboard') }}">
        ← ダッシュボードに戻る
    </a>
</div>
@endsection
