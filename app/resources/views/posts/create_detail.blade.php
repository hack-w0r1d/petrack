@extends('layouts.main')

@section('content')
<img src="{{ asset('storage/' . $imagePath) }}" class="upload-preview" alt="アップロード画像">

<form action="{{ route('posts.create.confirm') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="">ペット</label>
        <select name="pet_id" class="form-control" id="">
            <option value="">選択してください</option>
        </select>
    </div>

    <div class="form-group mt-3">
        <label for="">カテゴリー(3つまで)</label>
        <div>
            @foreach ($tags as $tag)
                <span class="badge badge-primary mr-1">{{ $tag->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="form-group mt-3">
        <label for="">キャプション</label>
        <textarea name="caption" id="" class="form-control" cols="30" rows="10"></textarea>
    </div>

    <button type="submit" class="btn btn-primary mt-3">投稿内容確認</button>
</form>
@endsection
