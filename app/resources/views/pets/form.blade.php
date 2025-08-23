@extends('layouts.main')

@section('content')
<div class="col-md-10 mx-auto">
    <h2 class="text-center my-4">
        {{ $pet->exists ? 'ペットを編集' : 'ペットを登録' }}
    </h2>
    <form action="{{ $pet->exists ? route('pets.update', $pet) : route('pets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($pet->exists)
            @method('PUT')
        @endif
        <div class="d-flex align-items-center mb-4">
            <div class="mr-4">
                <img src="{{ $pet->exists && $pet->image_path ? asset('storage/' . $pet->image_path) : asset('storage/uploads/default.png') }}" id="pet-preview" class="rounded-circle" alt="ペット画像">
            </div>
            <div class="d-flex flex-column">
                <span class="font-weight-bold">{{ auth()->user()->name }}</span>
                <label for="petImage" class="btn btn-outline-secondary mt-2">
                    写真を変更する
                    <input type="file" name="image" id="petImage" accept="image/*" hidden>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="name">ペット名</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $pet->name) }}" required>
        </div>
        <div class="form-group">
            <label for="gender">性別</label>
            <select name="gender" class="form-control">
                <option value="" {{ old('gender', $pet->gender) == '' ? 'selected' : '' }}>選択しない</option>
                <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>♂</option>
                <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>♀</option>
            </select>
        </div>
        <div class="form-group">
            <label for="birthday">誕生日</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', optional($pet->birthday)->format('Y-m-d')) }}">
        </div>
        <div class="form-group">
            <label for="species">種</label>
            <input type="text" name="species" class="form-control" value="{{ old('species', $pet->species) }}">
        </div>
        <div class="form-group">
            <label for="breed">品種</label>
            <input type="text" name="breed" class="form-control" value="{{ old('breed', $pet->breed) }}">
        </div>
        <div class="d-flex justify-content-around mt-4">
            <a href="{{ route('profile.show', auth()->id()) }}" class="btn btn-secondary">キャンセル</a>
            <button type="submit" class="btn btn-primary">{{ $pet->exists ? '保存' : '登録' }}</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('petImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('pet-preview');
            preview.src = URL.createObjectURL(file);
            preview.onload = () => URL.revokeObjectURL(preview.src);
        }
    })
</script>
@endsection
