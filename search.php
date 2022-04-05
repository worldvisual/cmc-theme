<?php get_header(); ?>
<?php $options = get_option('cmc_options'); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="primary<?php if ( wp_is_mobile() ) { echo ' without-sidebar '; } else { echo ' '; } ?>file-search">
        <?php
        	$paged = (get_query_var('paged'))?get_query_var('paged'):1; 
          $args = array(
            'post_type' => array('post', 'page', 'main_product', 'related_product_1', 'related_product_2', 'brands'),
            'paged' => $paged,
            's' => $_GET['s']
          );
          $query = new WP_Query($args);
          
          $term = '';
          if (!$query->have_posts()) {
            $term = 'No hay resultados';
          } else {
            $term = 'Resultado';
          }
          echo '<div class="search-content"> <h3>'. $term .' de búsqueda para <strong>' . $_GET['s'] . '</strong></h3></div>';
          
        ?>
				<div class="list-products">
          <?php
            if (!$query->have_posts()) {
              echo "<h5>No hemos encontrado lo que buscas, pero aquí te dejamos el ranking de las cafeteras más vendidas en España durante el día de ayer:</h5>";
              echo do_shortcode('[aawp bestseller="cafeteras express" items=9 grid=3]');
            }
          
          ?>
					
					<?php while($query->have_posts()): $query->the_post(); ?>
						<?php if(get_post_type() == 'main_product' || get_post_type() == 'related_product_1' || get_post_type() == 'related_product_2') { ?>
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
									<h2><a class="post-title-2" href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
								</div>
								<div class="entry-content-2"><?php
								$titleSize = strlen(get_the_title());
								if($titleSize >= 32 &&  $titleSize < 55 ){
									$psize = 90;
								} else if($titleSize >= 55) {
									$psize = 40;
								} else {
									$psize = 120;
								}
								//echo $titleSize;
								echo mb_substr(wp_strip_all_tags(get_the_content()), 0, $psize); 
								?>...</div>
								<?php if($data['price'] != '') { ?>
									<div class="read-more price"><span><?php echo $data['price']; ?> €</span></div>
								<?php } else { ?>
									<div class="read-more"><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Acceder'); ?></a></div>
								<?php } ?>
							</div>
						<?php } else { ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('article-2'); ?>>
								<header class="entry-header-2">
									<?php
										if(has_post_thumbnail()) { ?>
											<a class="post-thumbnail-2" href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail('image-medium'); ?></a>
										<?php }
										else { ?>
											<a class="post-thumbnail-2" href="<?php esc_url(the_permalink()); ?>"><!-- Default post thumbnail --></a>
										<?php }
									?>
									<h2><a class="post-title-2" href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
								</header>
								<div class="entry-content-2"><?php
								$titleSize = strlen(get_the_title());
								if($titleSize >= 33 &&  $titleSize < 55 ){
									$psize = 90;
								} else if($titleSize >= 55) {
									$psize = 40;
								} else {
									$psize = 120;
								}
								//echo $titleSize;
								echo mb_substr(wp_strip_all_tags(get_the_content()), 0, $psize); 
								?>...</div>
								<div class="read-more"><a href="<?php esc_url(the_permalink()); ?>"><?php _e('Leer más'); ?></a></div>
							</article>
						<?php } ?>
					<?php endwhile; ?>				
				</div>
				<?php get_template_part('content/content', 'pagination'); ?>
				<?php wp_reset_postdata(); ?>
			
		</div>
		<?php
      get_sidebar();
    ?>
	</div>
</main>

<?php get_footer(); ?>