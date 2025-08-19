@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- 投稿一覧 -->
        <div class="col-md-8 border-right">投稿一覧</div>
        <!-- おすすめ(仮) -->
        <div class="col-md-4">おすすめ</div>
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
