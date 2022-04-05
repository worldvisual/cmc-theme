<?php while(have_posts()): the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('article-2'); ?>>
		<header class="entry-header-2">
			<?php
				if(has_post_thumbnail()) { ?>
					<a class="post-thumbnail-2" href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail('post-thumbnail'); ?></a>
				<?php }
				else { ?>
					<a class="post-thumbnail-2" href="<?php esc_url(the_permalink()); ?>"><!-- Default post thumbnail --></a>
				<?php }
			?>
			<h2><a class="post-title-2" href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
		</header>
		<div class="entry-content-2"><?php echo substr(wp_strip_all_tags(get_the_excerpt()), 0, 135); ?>...</div>
		<div class="read-more"><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Leer más >>'); ?></a></div>
	</article>
<?php endwhile; ?>
<div class="clear"></div>