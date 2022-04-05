<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="primary<?php if ( wp_is_mobile() ) { echo ' without-sidebar '; } else { echo ' '; } ?>file-page">    
      <?php while(have_posts()): the_post(); ?>
				<?php $options = get_option('cmc_options'); ?>
				<?php get_template_part('content/content', 'page'); ?>
				<?php if (comments_open() || get_comments_number()): comments_template(); endif; ?>
				<?php if (comments_open() || get_comments_number()): echo $options['theme_legal_comments']['value']; endif; ?>
			<?php endwhile; ?>
		</div>
    <?php
      get_sidebar();
    ?>
	</div>
</main>

<?php get_footer(); ?>