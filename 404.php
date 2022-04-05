<?php
/*
	Template Name: Página 404
*/
?>
<?php get_header(); ?>
<?php $options = get_option('cmc_options'); ?>

<main role="main">
	<div class="wrapper container">
		<div id="primary" class="content-area<?php if ( wp_is_mobile() ) { echo ' without-sidebar '; } else { echo ' '; } ?>file-404">
			
			<?php 
			$not_found_page = get_page_by_path( 'pagina-404' );
			$content = '';
      $content = apply_filters( 'the_content', $not_found_page->post_content ); 
      echo $content;

			?>

			<div class="group-menus-404">
			<?php
      /*
				wp_nav_menu(
					array(
						'theme_location' => 'menu_404_1',
						'menu_class' => 'menu-404'
					)
				);
	
				wp_nav_menu(
					array(
						'theme_location' => 'menu_404_2',
						'menu_class' => 'menu-404'
					)
				);
	
				wp_nav_menu(
					array(
						'theme_location' => 'menu_404_3',
						'menu_class' => 'menu-404'
					)
				);
        */
			?>
			</div>
		</div>
		<?php
      get_sidebar();
    ?>
	</div>
</main>

<?php get_footer(); ?>