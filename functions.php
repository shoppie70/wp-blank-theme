<?php
/**
 * include config
 */
require_once get_parent_theme_file_path( '/inc/config.php' );

/*
 * incフォルダにあるファイルをすべて読み込む
 */
foreach ( glob( TEMPLATEPATH . "/inc/*.php" ) as $file ) {
  require_once $file;
}