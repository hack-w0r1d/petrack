// 横スクロールが発生しないようにする
const setScrollbarWidth = () => {
  const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth
  // カスタムプロパティの値を更新する
  document.documentElement.style.setProperty('--scrollbar', `${scrollbarWidth}px`);
};

// 表示されたとき
window.addEventListener('load', setScrollbarWidth);
// リサイズしたとき
window.addEventListener('resize', setScrollbarWidth);


document.addEventListener('DOMContentLoaded', function() {
  // フォローステータスの処理
  const followButtons = document.querySelectorAll('.follow-btn');
  let targetButton = null;

  followButtons.forEach(button => {
    button.addEventListener('mouseover', () => {
      if (button.dataset.isFollowing === '1') {
        button.textContent = 'フォロー解除';
        button.classList.remove('btn-primary');
        button.classList.add('btn-danger');
      }
    });

    button.addEventListener('mouseout', () => {
      if (button.dataset.isFollowing === '1') {
        button.textContent = 'フォロー中';
        button.classList.remove('btn-danger');
        button.classList.add('btn-primary');
      }
    });

    button.addEventListener('click', function () {
      const isFollowing = this.dataset.isFollowing === '1';

      if (isFollowing) {
        targetButton = this;
        document.getElementById('unfollowMessage').textContent = `${this.dataset.username}のフォローを解除しますか？`;
        $('#unfollowModal').modal('show');
      } else {
        toggleFollow(this,false);
      }
    });
  });
  // モーダル内の「解除」するボタン
  document.getElementById('confirmUnfollow').addEventListener('click', () => {
    if (targetButton) {
      toggleFollow(targetButton, true);
      $('#unfollowModal').modal('hide');
    }
  });
  // Ajax フォロー/解除処理
  function toggleFollow(button, isUnfollow) {
    const userId = button.dataset.userId;
    const url = isUnfollow ? `/unfollow/${userId}` : `/follow/${userId}`;
    const formData = new FormData();
    formData.append('_method', isUnfollow ? 'DELETE' : 'POST');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    fetch(url, {
      method: 'POST',
      body: formData,
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // トグル処理
        if (isUnfollow) {
          button.dataset.isFollowing = '0';
          button.textContent = 'フォローする';
          button.classList.remove('btn-primary', 'btn-danger');
          button.classList.add('btn-outline-primary');
        } else {
          button.dataset.isFollowing = '1';
          button.textContent = 'フォロー中';
          button.classList.remove('btn-outline-primary', 'btn-danger');
          button.classList.add('btn-primary');
        }
      } else {
        alert('処理に失敗しました');
      }
    })
    .catch(err => console.error(err));
  }
});


// document.addEventListener('DOMContentLoaded', () => {
//   let targetForm;

//   // フォロー解除ボタンが押されたら確認モーダル表示
//   document.querySelectorAll('.follow-btn').forEach(btn => {
//       btn.addEventListener('click', () => {
//           const username = btn.dataset.username;
//           targetForm = btn.closest('form');

//           document.getElementById('unfollowMessage').textContent = `${username} のフォローを解除しますか？`;

//           $('#unfollowModal').modal('show');
//       });
//   });

//   // 「解除する」が押されたらフォーム送信
//   document.getElementById('confirmUnfollow').addEventListener('click', () => {
//       if (targetForm) {
//           targetForm.submit();
//       }
//   });
// });
