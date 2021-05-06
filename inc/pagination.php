<?php
/**
* ページネーション出力関数
* $paged : 現在のページ
* $pages : 全ページ数
* $range : 左右に何ページ表示するか
* $show_only : 1ページしかない時に表示するかどうか
*/
function fit_pagination( $pages, $paged, $range = 4, $show_only = true ) {

    $pages = ( int ) $pages;    //float型で渡ってくるので明示的に int型 へ
    $pages = $pages;
    $paged = $paged ?: 1;       //get_query_var('paged')をそのまま投げても大丈夫なように
    

    //表示テキスト
    $text_first   = '<i class="fas fa-chevron-left"></i>';
    $text_last    = '<i class="fas fa-chevron-right"></i>';
    $text_dots    = '<i class="fas fa-ellipsis-h"></i>';

    if ( $show_only && $pages === 1 ) {
        // １ページのみで表示設定が true の時
        echo '<div class="pager"><span class="pager__numbers--active">1</span></div>';
        return;
    }

    if ( $pages === 1 ) return;    // １ページのみで表示設定もない場合

    if ( 1 !== $pages ) {
        //２ページ以上の時
        echo '<div class="pager">';
        if ( $paged > $range + 1 ) {
            // 「最初へ」 の表示
            echo '<a href="', get_pagenum_link(1) ,'" class="pager__numbers">', $text_first ,'</a>';
            echo '<span class="pager__numbers">', $text_dots ,'</span>';
        }
        for ( $i = 1; $i <= $pages; $i++ ) {

            if ( $i <= $paged + $range && $i >= $paged - $range ) {
                // $paged +- $range 以内であればページ番号を出力
                if ( $paged === $i ) {
                    echo '<span class="pager__numbers--active">', $i ,'</span>';
                } else {
                    echo '<a href="', get_pagenum_link( $i ) ,'" class="pager__numbers">', $i ,'</a>';
                }
            }

        }
        if ( $paged + $range < $pages ) {
            // 「最後へ」 の表示
            echo '<span class="pager__numbers">', $text_dots ,'</span>';
            echo '<a href="', get_pagenum_link( $pages ) ,'" class="pager__numbers">', $text_last ,'</a>';
        }
        echo '</div>';
    }
}
