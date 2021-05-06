<?php  get_template_part('template_part/common/top_nav'); ?>

<?php if( !is_front_page() ): ?>

    <?php

		if( is_post_type_archive( 'works' ) || is_singular( 'works' ) ){
			$image_link = imdir().'/header/works.jpg';
			$title      = '施工実績';
			$subtitle   = 'WORKS';
			$icon       = imdir().'/header/works_icon.png';
		}
        elseif( is_archive() || is_single() ){
            $image_link = imdir().'/header/information.jpg';
			$title      = 'お知らせ';
			$subtitle   = 'INFORMATION';
			$icon       = imdir().'/header/information_icon.png';
        }
        else{
            $image_link = imdir().'/header/'.slug().'.jpg';
			$title      = get_the_title();
			$subtitle   = strtoupper( slug() );
			$icon       = imdir().'/header/'.slug().'_icon.png';
        }

    ?>

	<div class="header__lower lazyload wow fadeIn" data-bg="<?php echo $image_link; ?>" data-wow-duration="2s">
		<div class="header__lower--title">
			<div class="heading">
				<img class="lazyload" src="" data-src="<?php echo $icon; ?>" alt="">
				<h1 class="heading__main"><?php echo $title; ?></h1>
				<span class="heading__sub"><?php echo $subtitle; ?></span>
			</div>
		</div>
	</div>

	<?php fit_breadcrumb(); ?>

<?php endif; ?>

<?php get_template_part('template_part/common/floating-btn'); ?>
