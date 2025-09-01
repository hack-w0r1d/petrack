@extends('layouts.main')

@section('content')
<div class="col-md-10 mx-auto">
    <h2 class="text-center my-4">
        プロフィール編集
    </h2>
    <!-- プロフィール編集フォーム -->
    <form action="{{ route('profile.update', ['profile' => auth()->user()->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="d-flex align-items-center mb-4">
            <div class="mr-4">
                <img src="{{ asset('storage/' . auth()->user()->image_path) }}" id="profile-img-preview" class="rounded-circle" alt="プロフィール画像">
            </div>
            <div class="d-flex flex-column">
                <span class="font-weight-bold">{{ auth()->user()->name }}</span>
                <label for="profileImage" class="btn btn-outline-secondary mt-2">
                    写真を変更する
                    <input type="file" name="image" id="profileImage" accept="image/*" hidden>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="bio">自己紹介</label>
            <textarea name="bio" class="form-control" cols="30" rows="10">{{ old('bio', auth()->user()->bio) }}</textarea>
        </div>
        <div class="d-flex justify-content-around mt-4">
            <a href="{{ route('profile.show', auth()->id()) }}" class="btn btn-secondary w-25">キャンセル</a>
            <button type="submit" class="btn btn-primary w-25">更新する</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('profileImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('profile-img-preview');
            preview.src = URL.createObjectURL(file);
            preview.onload = () => URL.revokeObjectURL(preview.src);
        }
    })
</script>
@endsection
