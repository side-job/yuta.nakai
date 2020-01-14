$(function(){
      // #で始まるアンカーをクリックした場合に処理
   $('a[href^=#]').click(function() {
      // スクロールの速度
      var speed = 1000; // ミリ秒
      // アンカーの値取得
      var href= $(this).attr("href");
      // 移動先を取得
      var target = $(href == "#" || href == "" ? 'html' : href);
      // 移動先を数値で取得
      var position = target.offset().top;
      // スムーススクロール
      $('body,html').animate({scrollTop:position}, speed, '500');
      return false;
   });
    var effect_pos = -400; // 画面下からどの位置でフェードさせるか(px)
    var effect_move = 100; // どのぐらい要素を動かすか(px)
    var effect_time = 800; // エフェクトの時間(ms) 1秒なら1000

    // // フェードする前のcssを定義
    // $('.scroll-fade').css({
    //     opacity: 0,
    //     transform: 'translateY('+ effect_move +'px)',
    //     transition: effect_time + 'ms'
    // });

    // スクロールまたはロードするたびに実行
    $(window).on('scroll load', function(){
        var scroll_top = $(this).scrollTop();
        var scrollscroll-fade_btm = scroll_top + $(this).height();
        effect_pos = scroll_btm - effect_pos;

        // effect_posscroll-fadeがthis_posを超えたとき、エフェクトが発動
        $('.').each( function() {
            var this_pos = $(this).offset().top;
            if ( effect_pos > this_pos ) {
                $(this).css({
                    opacity: 1,
                    transform: 'translateY(0)'
                });
            }
        });
    });
      

});

