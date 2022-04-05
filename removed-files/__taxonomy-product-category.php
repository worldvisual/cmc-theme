<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="primary without-sidebar">
			<h1 class="center"><?php _e('Productos de la categoría: '); echo single_cat_title('', false); ?></h1>
			<div class="category-description"><?php echo category_description(); ?></div>
			<div class="list-productss">
				<?php while(have_posts()): the_post(); ?>

					<?php $data = cmc_get_prodcut_data(get_the_ID(), get_post_type()); ?>
					<?php
						$main_prod_image = get_post_meta(get_the_ID(), '_main_product_img', true);
							$image = esc_attr($main_prod_image);
							$image_src_sm=wp_get_attachment_image_src($image, 'medium');
					?>
					<div class="article-2">
						<div class="entry-header-2">
							<?php
								if(!empty($data['image-medium'])) { ?>
									<a class="post-thumbnail-2" href="<?php the_permalink(); ?>"><img src="<?php echo $data['image-medium']; ?>"></a>
								<?php }
								else { ?>
									<a class="post-thumbnail-2" href="<?php the_permalink(); ?>"><!-- Default post thumbnail --></a>
								<?php }
							?>
							<h2><a class="post-title-2" href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
						</div>
						<div class="entry-content-2"><?php echo substr(wp_strip_all_tags(get_the_excerpt()), 0, 135); ?>...</div>
						<?php if($data['price'] != '') { ?>
							<div class="read-more price"><?php echo $data['price']; ?>€</div>
						<?php } else { ?>
							<div class="read-more"><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Acceder >>'); ?></a></div>
						<?php } ?>
					</div>

				<?php endwhile; ?>

			</div>

			<div class="clear"></div>
			<input type="hidden" id="cmcPostType" value="<?php echo get_post_type(); ?>">
			<input type="hidden" id="cmcTaxonomy" value="<?php echo get_query_var('taxonomy'); ?>">
			<input type="hidden" id="cmcTerm" value="<?php echo get_queried_object()->slug; ?>">
			<input type="hidden" id="cmcOffset" value="<?php echo get_option('posts_per_page'); ?>">
			<input type="hidden" id="cmcSearch" value="1">
			<a href="#" id="cmcMoreProducts" class="button-2"><?php _e('Cargar más productos'); ?></a>
			<div id="loading"><?php _e('Cargando...'); ?></div>
			<div class="cmc-message"><?php _e('Ya hemos listado todos los productos. Si necesitas encontrar más artículos, por favor revisa otras categorías de la web'); ?></div>
			<div class="category-description"><p><?php echo the_field('description-2', 'product-category_' . get_queried_object()->term_id); ?></p></div>

		</div>
	</div>
</main>

<?php get_footer(); ?>