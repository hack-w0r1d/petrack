const setScrollbarWidth = () => {
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth
    // カスタムプロパティの値を更新する
    document.documentElement.style.setProperty('--scrollbar', `${scrollbarWidth}px`);
  };

  // 表示されたとき
  window.addEventListener('load', setScrollbarWidth);
  // リサイズしたとき
  window.addEventListener('resize', setScrollbarWidth);
