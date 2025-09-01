@extends('layouts.main')

@section('content')
<img src="{{ asset('storage/' . $imagePath) }}" class="upload-preview" alt="アップロード画像">

<form action="{{ route('posts.create.confirm') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="pet_id">ペット名</label>
        <select name="pet_id" id="pet_id" class="form-control">
            <option value="">選択してください</option>
            @foreach($pets as $pet)
                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="tag-list">
        <p class="d-flex flex-wrap mb-0">カテゴリー（3つまで）</p>
        @foreach($tags as $tag)
            <label class="tag-item">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="d-none tag-checkbox">
                <span class="tag-label">{{ $tag->name }}</span>
            </label>
        @endforeach
    </div>

    <div class="form-group mt-3">
        <label for="">キャプション（300文字以内）</label>
        <textarea name="caption" id="" class="form-control" cols="30" rows="10"></textarea>
    </div>

    <button type="submit" class="btn btn-primary mt-3">投稿内容確認</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.tag-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const checked = document.querySelectorAll('.tag-checkbox:checked');
                if (checked.length > 3) {
                    checkbox.checked = false;
                    alert('タグは最大3つまで選択できます');
                }
            });
        });
    });
</script>
@endsection
