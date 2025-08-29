@extends('layouts.main')

@section('content')

<div class="col-md-10 mx-auto">
    <div class="container">
        <h2 class="text-center my-4">{{ $user->name }}のフォロー一覧</h2>

        @foreach($followings as $following)
            <div class="d-flex align-items-start justify-content-between py-3">
                <div class="d-flex align-items-start">
                    <img src="{{ asset('storage/' . $following->image_path )}}" class="rounded-circle mr-3 follow-list-icon" alt="プロフィール画像">
                    <div>
                        <div>
                            <a href="{{ route('profile.show', $following->id) }}" class="font-weight-bold">
                                {{ $following->name }}
                            </a>
                        </div>
                        <div class="text-muted small">
                            {{ $following->bio }}
                        </div>
                    </div>
                </div>
                @if($following->id !== auth()->id())
                    <button type="button" class="btn btn-sm btn-primary follow-btn" data-username="{{ $following->name }}" data-user-id="{{ $following->id }}" data-is-following="{{ auth()->user()->isFollowing($following->id) ? '1' : '0' }}">
                        {{ auth()->user()->isFollowing($following->id) ? 'フォロー中' : 'フォローする' }}
                    </button>
                @endif
            </div>
        @endforeach
    </div>
</div>

@include('components.unfollow-modal')

@endsection
