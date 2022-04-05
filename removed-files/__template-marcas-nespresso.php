<?php
/*
	Template Name: Cafeteras Nespresso
	Template Post Type: page
*/
?>
<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="primary without-sidebar">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-header">
					<h1><?php _e('Cafeteras Nespresso');?></h1>
				</div>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
    </div>
	</div>
</main>

<?php get_footer(); ?>
