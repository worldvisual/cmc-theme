<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="content-area<?php if ( wp_is_mobile() ) { echo ' without-sidebar '; } else { echo ' '; } ?>list-posts file-index">
				<h1><?php _e('Blog de ComprarMiCafetera.com'); ?></h1>
				<?php
					$page_for_posts_id = get_option( 'page_for_posts' );
					$page_for_posts_obj = get_post( $page_for_posts_id );
					echo apply_filters( 'the_content', $page_for_posts_obj->post_content );
				?>
				<?php get_template_part('content/content', 'loop'); ?>		
				<?php get_template_part('content/content', 'pagination'); ?>
		</div>
		<?php
      get_sidebar();
    ?>
	</div>
</main>

<?php get_footer(); ?>