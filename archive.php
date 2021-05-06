<?php

    $post_type = get_post_type() ?: get_query_var( 'post_type' );

    $args = [
        'paged'          => $paged,
        'post_type'      => 'post',    // 投稿
        'post_status'    => 'publish', // 公開された投稿、または固定ページを表示(デフォルト)
        'posts_per_page' => 10,        // 表示する投稿数(-1を指定すると全投稿を表示)
    ];

    // クエリの定義
    $wp_query = new WP_Query( $args );

?>

<?php get_header(); ?>
	<article class="information bg-yellow">
		<section class="container bg-white pb-20">

			<div class="archive__buttons">
				<div class="archive__date">
					<select class="archive__buttons--select" name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'>
						<option value=""><?php echo attribute_escape(__('Select Month')); ?></option>
						<?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?>
					</select>
				</div>
			</div>

			<?php if ( $wp_query->have_posts() ) : ?>
				<ul class="information__list">
					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
						<li class="information__list--item">
								<time class="information__time" datetime="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'Y.m.d' ); ?></time>
							<a href="<?php the_permalink(); ?>">
								<h2 class="information__title">
									<?php the_title(); ?>
								</h2>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php else: ?>
				<p class="text-center">投稿はありません</p>
			<?php endif; wp_reset_postdata(); ?>

			<aside class="pagenation pc-only">
				<?php fit_pagination( $wp_query->max_num_pages, $paged ); ?>
			</aside>

		</section>
	</article>
<?php get_footer(); ?>