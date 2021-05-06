<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
    <title><?php echo !is_home() ? wp_title('-', true, 'right') : bloginfo('name'); ?></title>
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
	<?php get_template_part('template_part/common/styles'); ?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/plugins/unveilhooks/ls.unveilhooks.min.js"></script>
    <?php wp_head(); ?>
</head>

<body class="drawer drawer--right">
    <header class="header" role="banner">
        <?php get_template_part('template_part/layouts/header'); ?>
        <?php get_template_part('template_part/parts/drawer'); ?>
    </header>
    <main id="main" class="main" role="main">
