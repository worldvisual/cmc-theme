<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="content-area<?php if ( wp_is_mobile() ) { echo ' without-sidebar '; } else { echo ' '; } ?>file-category">

					<h1><?php _e('Estás en la categoría:'); ?> <?php single_cat_title(); ?></h1>
					<?php get_template_part('content/content', 'loop'); ?>
					<?php get_template_part('content/content', 'pagination'); ?>
		
		</div>
		<?php
      get_sidebar();
    ?>
	</div>
</main>

<?php get_footer(); ?>