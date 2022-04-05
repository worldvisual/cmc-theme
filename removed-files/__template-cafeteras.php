<?php
/*
	Template Name: Listar Cafeteras
	Template Post Type: page
*/
?>
<?php get_header(); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="primary without-sidebar">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-header">
					<h1><?php _e('Todas las Cafeteras');?></h1>
				</div>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<div class="list-products">
				<?php $paged = (get_query_var('paged'))?get_query_var('paged'):1; ?>
				<?php
					$args = array(
						'posts_per_page' => get_option('posts_per_page'),
						'post_type' => 'main_product',
						'orderby' => 'DATE',
						'order' => 'DESC',
						'paged' => $paged
					);
					$query = new WP_Query($args);
				?>
				<?php while($query->have_posts()): $query->the_post(); ?>
					<?php $data = cmc_get_prodcut_data(get_the_ID(), get_post_type()); ?>
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
							<a class="post-title-2" href="<?php esc_url(the_permalink()); ?>"><h2><?php the_title(); ?></h2></a>
						</div>
						<div class="entry-content-2"><?php echo mb_substr(wp_strip_all_tags(get_the_content()), 0, 135); ?>...</div>
						<?php if($data['price'] != '') { ?>
							<div class="read-more price"><span><?php echo $data['price']; ?> €</span></div>
						<?php } else { ?>
							<div class="read-more"><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Acceder >>'); ?></a></div>
						<?php } ?>
					</div>
				<?php endwhile; ?>
				<!--<div class="clear"></div>
				<ul class="product-pagination">
					<li><?php previous_posts_link('&laquo; ' . __('Ant.'), $query->max_num_pages); ?></li>
					<li><?php next_posts_link(__('Sig.') . ' &raquo;', $query->max_num_pages); ?></li>
				</ul>
				<?php wp_reset_postdata(); ?>-->
			</div>

			<div class="clear"></div>
			<input type="hidden" id="cmcPostType" value="main_product">
			<input type="hidden" id="cmcTaxonomy" value="">
			<input type="hidden" id="cmcTerm" value="">
			<input type="hidden" id="cmcOffset" value="<?php echo get_option('posts_per_page'); ?>">
			<input type="hidden" id="cmcSearch" value="1">
			<a href="#" id="cmcMoreProducts" class="button-2"><?php _e('Cargar más productos'); ?></a>
			<div id="loading"><?php _e('Cargando...'); ?></div>
			<div class="cmc-message"><?php _e('Ya hemos listado todos los productos. Si necesitas encontrar más artículos, por favor revisa otras categorías de la web'); ?></div>

		</div>
	</div>
</main>

<?php get_footer(); ?>