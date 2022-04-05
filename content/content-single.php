<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
		<div class="page-meta"><?php _e('Última actualización: ') . the_modified_date(get_option('date_format')); ?></div>
	</header>
		
	<?php if(get_post_type() == 'brands') {
		$brand_website = get_post_meta(get_the_ID(), '_brand_website', true);
		$image = esc_attr(get_post_meta(get_the_ID(), '_brand_img', true));
		echo '<div class="brand-info">
				<img src="' . wp_get_attachment_image_src($image, 'medium')[0] . '">
				<a href="' . $brand_website . '" target="_blank" rel="nofollow">Web oficial</a>
			</div><div class="clear"></div>';
	} ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>