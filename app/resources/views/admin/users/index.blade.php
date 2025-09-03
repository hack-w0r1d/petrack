@extends('layouts.main')

@section('content')
<div class="container">
    @if(session('destroy'))
        <div class="alert alert-danger">
            {{ session('destroy') }}
        </div>
    @endif
    <h2 class="text-center my-4">ユーザー管理</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メール</th>
                <th>登録日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <a href="{{ route('profile.show', $user->id) }}" style="color: #3490dc;">
                            {{ $user->id }}
                        </a>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？この操作は元に戻せません。');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
    <a class="btn btn-primary return-dashboard-btn" href="{{ route('admin.dashboard') }}">
        ← ダッシュボードに戻る
    </a>
</div>
@endsection
