<?php 

function cmc_scripts_header(){
	wp_enqueue_style('nhf-bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap-light.min.css');
	wp_enqueue_style('cmc-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'), false);
}
add_action('wp_enqueue_scripts', 'cmc_scripts_header');


function cmc_scripts(){

	wp_enqueue_script('wp-embed');

	$is_custom_taxonomy = strpos(get_post_permalink(), 'molinillos') || strpos(get_post_permalink(), 'cafeteras') || strpos(get_post_permalink(), 'espumadores-de-leche');

	if ($is_custom_taxonomy) {
		wp_enqueue_script('cmc-taxonomy-js', get_template_directory_uri() . '/assets/js/taxonomy.min.js');
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) wp_enqueue_script('comment-reply');
	wp_enqueue_script('nhf-font-awesome', 'https://kit.fontawesome.com/88857f69ea.js');
	wp_enqueue_script('nhf-script', get_template_directory_uri() . '/assets/js/script.min.js');
}
add_action('wp_footer', 'cmc_scripts');
