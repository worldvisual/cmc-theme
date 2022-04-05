<?php 

function cmc_widgets(){

	register_sidebar(array(
		'name' => 'Sidebar Widgets',
		'id' => 'sidebar-widgets',
		'description' => __('Widgets del sidebar'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));

	register_sidebar(array(
		'name' => 'Footer Widgets - Columna 1',
		'id' => 'footer-widgets-1',
		'description' => __('Widgets para la columna 1 del footer'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>'
	));

	register_sidebar(array(
		'name' => 'Footer Widgets - Columna 2',
		'id' => 'footer-widgets-2',
		'description' => __('Widgets para la columna 2 del footer'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>'
	));

	register_sidebar(array(
		'name' => 'Footer Widgets - Columna 3',
		'id' => 'footer-widgets-3',
		'description' => __('Widgets para la columna 3 del footer'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>'
	));

	/** 4TH WIDGET FOR NEW FOOTER */
	register_sidebar(array(
		'name' => 'Footer Widgets - Columna 4',
		'id' => 'footer-widgets-4',
		'description' => __('Widgets para la columna 4 del footer'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>'
	));

	/** 5TH WIDGET FOR NOTICE */
	register_sidebar(array(
		'name' => 'Footer Widgets - Columna 5',
		'id' => 'footer-widgets-5',
		'description' => __('Widgets para la columna 5 del footer'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5>',
		'after_title' => '</h5>'
	));
}
add_action('widgets_init', 'cmc_widgets');
