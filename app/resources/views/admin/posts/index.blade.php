@extends('layouts.main')

@section('content')
<div class="container">
    @if(session('destroy'))
        <div class="alert alert-danger">
            {{ session('destroy') }}
        </div>
    @endif
    <h2 class="text-center my-4">投稿管理</h2>
    <!-- ドロップダウン -->
    <form action="{{ route('admin.posts.index') }}" method="GET" class="mb-3">
        <select name="filter" id="" onchange="this.form.submit()" class="form-control w-auto d-inline-block">
            <option value="with" {{ $filter === 'with' ? 'selected' : '' }}>全ての投稿（削除済みを含む）</option>
            <option value="without" {{ $filter === 'without' ? 'selected' : '' }}>削除されていない投稿のみ</option>
            <option value="only" {{ $filter === 'only' ? 'selected' : '' }}>削除済みのみ</option>
        </select>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>投稿ID</th>
                <th>ユーザーID</th>
                <th>キャプション</th>
                <th>投稿日</th>
                <th>削除ステータス</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}" style="color: #e3342f;">
                            {{ $post->id }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('profile.show', $post->user->id) }}" style="color: #3490dc;">
                            {{ $post->user->id }}
                        </a>
                    </td>
                    <td>{{ $post->caption }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                        @if($post->deleted_at)
                            <span style="color: red;">削除中</span>
                        @endif
                    </td>
                    <td>
                        @if(!$post->deleted_at)
                            <!-- 論理削除ボタン -->
                            <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-warning btn-sm">論理削除</button>
                            </form>
                        @else
                            <div class="d-flex">
                                <!-- 削除取消ボタン -->
                                <form action="{{ route('admin.posts.restore', $post->id) }}" method="POST" class="mr-2" onsubmit="return confirm('削除を取り消しますか？');">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-primary btn-sm">削除取消</button>
                                </form>
                                <!-- 物理削除ボタン -->
                                <form action="{{ route('admin.posts.forceDelete', $post->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？この操作は元に戻せません。');">
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
        {{ $posts->appends(['filter' => $filter])->links() }}
    </div>
    <a class="btn btn-primary return-dashboard-btn" href="{{ route('admin.dashboard') }}">
        ← ダッシュボードに戻る
    </a>
</div>
@endsection
