@extends('layouts.main')

@section('content')
<h2 class="my-4 text-center">新規投稿作成</h2>

<form id="imageForm" action="{{ route('posts.create.detail') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="image">画像を選択</label>
        <input type="file" name="image" id="imageInput" class="form-control">
        <div id="errorMsg" class="text-danger mt-1" style="display: none;">
            ファイルを選択してください
        </div>
        @error('image')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary mt-3">次へ</button>
</form>

<script>
    document.getElementById('imageForm').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('imageInput');
    const errorMsg = document.getElementById('errorMsg');

    if (!fileInput.value) {
        e.preventDefault();
        errorMsg.style.display = 'block';
    } else {
        errorMsg.style.display = 'none';
    }
    });
</script>
@endsection
