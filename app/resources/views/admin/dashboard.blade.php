@extends('layouts.main')

@section('content')
<div class="container">
    <h2 class="text-center mt-4">管理者ダッシュボード</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-block">
                👥ユーザー管理
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-success btn-block">
                📝投稿管理
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.comments.index') }}" class="btn btn-danger btn-block">
                💬コメント管理
            </a>
        </div>
    </div>
</div>
@endsection
