<?php get_header(); ?>
	<article class="single bg-yellow">
		<section class="single__content bg-white container pb-10">
			<div class="information__post">
				<h2 class="works__title"><?php the_title(); ?></h2>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
				<aside>
					<div class="works__post-link--wrap">
						<div class="works__post-link--before" style="<?php echo get_previous_post_link() ? '' : 'background-color: white;'; ?>">
							<?php previous_post_link('%link', '前の記事'); ?>
						</div>
						<div class="works__post-link--next" style="<?php echo get_next_post_link() ? '' : 'background-color: white;'; ?>">
							<?php next_post_link('%link', '次の記事'); ?>
						</div>
					</div>
				</aside>
			</div>
		</section>
	</article>
<?php get_footer(); ?>