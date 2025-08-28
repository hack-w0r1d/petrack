@extends('layouts.main')

@section('content')
<div class="col-md-10 mx-auto">
    <div class="container">
        <h2 class="text-center mb-4">フォロー</h2>

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
                <form action="#" method="POST" class="unfollow-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-primary unfollow-btn" data-user-id="{{ $following->id }}">
                        フォロー中
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <!-- フォロー解除の確認ダイアログ -->
    <div class="modal fade" id="unfollowModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h5 class="modal-title">確認</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="unfollowMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                    <button type="button" class="btn btn-danger" id="confirmUnfollow">解除する</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let targetForm;

        // フォロー解除ボタンが押されたら確認モーダル表示
        document.querySelectorAll('.unfollow-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const username = btn.dataset.username;
                targetForm = btn.closest('form');

                document.getElementById('unfollowMessage').textContent = `${username} のフォローを解除しますか？`;

                $('#unfollowModal').modal('show');
            });
        });

        // 「解除する」が押されたらフォーム送信
        document.getElementById('confirmUnfollow').addEventListener('click', () => {
            if (targetForm) {
                targetForm.submit();
            }
        });
    });
</script>
@endsection
