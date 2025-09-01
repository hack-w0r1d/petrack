@extends('layouts.main')

@section('content')

<div class="col-md-10 mx-auto">
    <div class="container">
        <h2 class="text-center my-4">{{ $user->name }}のフォロワー一覧</h2>

        @foreach($followers as $follower)
            <div class="d-flex align-items-start justify-content-between py-3">
                <div class="d-flex align-items-start">
                    <a href="{{ route('profile.show', $follower->id) }}" class="font-weight-bold">
                        <img src="{{ asset('storage/' . $follower->image_path )}}" class="rounded-circle mr-3 follow-list-icon" alt="プロフィール画像">
                    </a>
                    <div>
                        <div>
                            <a href="{{ route('profile.show', $follower->id) }}" class="font-weight-bold">
                                {{ $follower->name }}
                            </a>
                        </div>
                        <div class="text-muted small">
                            {{ $follower->bio }}
                        </div>
                    </div>
                </div>
                @if($follower->id !== auth()->id())
                    <button type="button" class="btn btn-sm btn-primary follow-btn" data-username="{{ $follower->name }}" data-user-id="{{ $follower->id }}" data-is-following="{{ auth()->user()->isFollowing($follower->id) ? '1' : '0' }}">
                        {{ auth()->user()->isFollowing($follower->id) ? 'フォロー中' : 'フォローする' }}
                    </button>
                @endif
            </div>
        @endforeach
    </div>
</div>

@include('components.unfollow-modal')

@endsection
