<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="primary without-sidebar file-single-main_product">
			<?php while(have_posts()): the_post(); ?>
				<?php get_template_part('content/content', 'single-main_product'); ?>
			<?php endwhile; ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>