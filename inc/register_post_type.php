<?php


/**
 * 投稿アーカイブページの作成
 * 変更後、「WordPressの管理画面」＞「設定」＞「パーマリンク設定」画面で「変更を保存」ボタンをクリックする
 */
add_filter( 'register_post_type_args', function ( $args, $post_type ) {
	global $wp_rewrite;
	if ( 'post' === $post_type ) {
		$archive_slug        = 'topics';
		$args['has_archive'] = $archive_slug;
		$archive_slug        = $wp_rewrite->root . $archive_slug;
		add_rewrite_rule( "{$archive_slug}/?$", "index.php?post_type=$post_type", 'top' );
		$feeds = '(' . trim( implode( '|', $wp_rewrite->feeds ) ) . ')';
		add_rewrite_rule( "{$archive_slug}/feed/$feeds/?$", "index.php?post_type=$post_type" . '&feed=$matches[1]',
			'top' );
		add_rewrite_rule( "{$archive_slug}/$feeds/?$", "index.php?post_type=$post_type" . '&feed=$matches[1]', 'top' );
		add_rewrite_rule( "{$archive_slug}/{$wp_rewrite->pagination_base}/([0-9]{1,})/?$",
			"index.php?post_type=$post_type" . '&paged=$matches[1]', 'top' );
	}

	return $args;
}, 10, 2 );

add_filter( 'post_type_archive_link', function ( $link, $post_type ) {
	if ( 'post' === $post_type ) {
		$link = home_url( 'topics/' );
	}

	return $link;
}, 10, 2 );

/* 投稿名の変更 */
add_action( 'admin_menu', function () {
	global $menu;
	global $submenu;
	$menu[5][0]                 = 'お知らせ';
	$submenu['edit.php'][5][0]  = 'お知らせ一覧';
	$submenu['edit.php'][10][0] = '新しい投稿';
	$submenu['edit.php'][16][0] = 'タグ';
} );

add_action( 'init', function () {
	global $wp_post_types;
	$wp_post_types['post']->label = 'お知らせ';
	$labels                       = $wp_post_types['post']->labels;
	$labels->name                 = 'お知らせ';
	$labels->singular_name        = 'お知らせ';
} );
