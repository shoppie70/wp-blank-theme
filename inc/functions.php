<?php

/**
 *  抜粋正弦.
 */
function my_excerpt_length($length)
{
    return 45;
}
add_filter('excerpt_mblength', 'my_excerpt_length');

// 抜粋末尾の文字列を[…]から変更する
function my_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'my_excerpt_more');

/**
 * ページスラッグの取得.
 */
function slug()
{
    global $post;

    return $post->post_name;
}

/**
 *  get_template_directory_uri()の短縮版
 *  /assets/img/以下のディレクトリ名とファイル名をパラメータとする
 */
function imdir($file_name = null)
{
    if ($file_name) {
        $url = esc_url(get_template_directory_uri().'/assets/img'.$file_name);
        $path = get_template_directory().'/assets/img'.$file_name;

        return $url.'?'.date('YmdHis', filemtime($path));
    } else {
        return esc_url(get_template_directory_uri().'/assets/img');
    }
}

/**
 * htmlspecialcharsのラッパー関数.
 *
 * @return string
 */
function e($value, $doubleEncode = true)
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8', $doubleEncode);
}

/**
 * curlのラッパー関数.
 *
 * @return string
 */
function curl($url, $timeout = 30, $settings_array = [])
{
    $contents = false;
    if (function_exists('curl_init')) {
        $curl_options = [
     CURLOPT_URL => $url,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_TIMEOUT => intval($timeout),
     CURLOPT_HEADER => false,
   ];
        // We assume nobody's going to try to overwrite the settings above
        array_merge($curl_options, $settings_array);
        if (!$curl_open = curl_init()) {
            $contents = false;
        }
        curl_setopt_array($curl_open, $curl_options);
        $contents = curl_exec($curl_open);
        curl_close($curl_open); // Close CURL
    } elseif (function_exists('passthru')) {
        $cmd = "curl -m $timeout -s-url ".$url.''; // Set up command
        ob_start();
        passthru($cmd, $status); // Run command
     $contents = ob_get_contents(); // Put everything into the variable
   ob_end_clean();
        if ($status > 1) {
            $contents = false;
        }
    }

    return $contents;
}