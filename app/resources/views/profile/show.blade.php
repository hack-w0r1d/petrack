@extends('layouts.main')

@section('content')
<div class="col-md-10 mx-auto">
    <div class="container mt-4">
        <div class="row align-items-center">
            <!-- プロフィール画像 -->
            <div class="col-md-3" tect-center>
                <img src="{{ asset('storage/' . $user->image_path) }}" class="rounded-circle profile-img" alt="プロフィール画像">
            </div>
            <!-- ユーザー情報 -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>{{ $user->name }}</h4>

                    <!-- プロフィール編集 / フォローステータス -->
                    <!-- 自分のプロフィールかどうかで表示切り替え -->
                    @if(auth()->id() === $user->id)
                        <a href="{{ route('profile.edit', ['profile' => Auth::user()->id]) }}" class="btn btn-outline-secondary btn-sm">プロフィール編集</a>
                    @else
                        <follow-button :user-id="{{ $user->id }}"></follow-button>
                    @endif
                </div>

                <!-- 投稿件数 / フォロー / フォロワー -->
                <div class="mt-2">
                    <span>投稿<strong>{{ $user->posts->count() }}</strong>件</span>
                    <span class="ml-3">フォロー<strong>$user->followings->count()</strong>人</span>
                    <span class="ml-3">フォロワー<strong>$user->followers->count()</strong>人</span>
                </div>

                <!-- プロフィール紹介文 -->
                <div class="mt-2">
                    <p>{{ $user->bio }}</p>
                </div>
            </div>
            <!-- ペット -->
            <div class="d-flex align-items-center">
                @if($user->id === Auth::id())
                    @if($user->pets->isNotEmpty())
                        @foreach($user->pets as $pet)
                            <a href="{{ route('pets.edit', ['pet' => $pet]) }}">
                                <img src="{{ asset('storage/' . $pet->image_path) }}" class="rounded-circle pet-icon {{ $loop->last ? '' : 'mr-5' }}" alt="{{ $pet->name }}">
                            </a>
                        @endforeach
                    @endif

                    <a href="{{ route('pets.create') }}" class="mt-4 ml-5 pt-2">
                        <i class="bi bi-plus-circle text-secondary" style="font-size: 6vw;"></i>
                        <div class="text-center text-white">ペット追加</div>
                    </a>
                @else
                    @if($user->pets->isNotEmpty())
                        @foreach($user->pets as $pet)
                            <img src="{{ asset('storage/' . $pet->image_path) }}" class="rounded-circle pet-icon mr-2" alt="{{ $pet->name }}">
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="d-flex border-bottom mb-3">
            <button class="btn btn-link flex-fill text-muted active" style="font-size: 24px;"><i class="bi bi-grid-3x3"></i></button>
            <button class="btn btn-link flex-fill text-muted"><i class="fa-solid fa-paw fa-2x"></i></button>
        </div>
        <div class="row">
            @foreach($user->posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card" style="object-fit: cover;">
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top profile-post-img" alt="投稿画像">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
