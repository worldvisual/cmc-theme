<?php
/*
	Template Name: Página con sidebar
	Template Post Type: page, brands
*/
?>
<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="primary<?php if ( wp_is_mobile() ) { echo ' without-sidebar '; } else { echo ' '; } ?>file-page-with-sidebar">
    	<?php while(have_posts()): the_post(); ?>
				<?php get_template_part('content/content', 'page'); ?>
				<?php if (comments_open() || get_comments_number()): comments_template(); endif; ?>
			<?php endwhile; ?>

		</div>
		<?php
      get_sidebar();
    ?>
	</div>
</main>

<?php get_footer(); ?>