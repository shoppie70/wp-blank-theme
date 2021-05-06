<?php
/**
 * setup theme
 */
add_action( 'after_setup_theme',  function(){
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
});

add_action('init', function(){
  session_start();
});
