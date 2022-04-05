<?php

/*
|--------------------------------------------------------------------------
| Gallery - CUSTOM POST TYPE
|--------------------------------------------------------------------------
*/
function cmc_create_cpt_gallery(){
  $labels = array(
    'name' 						=> __('Galerías'),
    'singular_name' 			=> __('Galería'),
    'menu_name' 				=> __('Galerías'),
    'name_admin_bar' 			=> __('Galerías'),
    'archives' 					=> __('Archivo de galerías'),
    'parent_item_colon' 		=> __('Galería padre:'),
    'all_items' 				=> __('Todos los elementos'),
    'add_new' 					=> __('Añadir nuevo'),
    'add_new_item' 				=> __('Añadir nuevo elemento'),
    'edit' 						=> __('Editar'),
    'edit_item' 				=> __('Editar galería'),
    'new_item' 					=> __('Nueva galería'),
    'view' 						=> __('Ver'),
    'view_item' 				=> __('Ver galería'),
    'update_item' 				=> __('Actualizar galería'),
    'search_items' 				=> __('Buscar galerías'),
    'not_found' 				=> __('No se ha encontrado ningún elemento que coincida'),
    'not_found_in_trash' 		=> __('No se ha encontrado ninguna galería que coincida en la papelera'),
    'featured_image' 			=> __('Imagen destacada'),
    'set_featured_image' 		=> __('Asignar imagen destacada'),
    'remove_featured_image' 	=> __('Quitar la imagen destacada'),
    'use_featured_image' 		=> __('Usar una imagen destacada'),
    'insert_into_item' 			=> __('Insertar en la galería'),
    'uploaded_to_this_item' 	=> __('Subido a esta galería'),
    'items_list' 				=> __('Lista de galerías'),
    'items_list_navigation' 	=> __('Navegación lista de galerías'),
    'filter_items_list' 		=> __('Filtrar lista de galerías')
  );

  $args = array(
    'label' 				=> __('product-gallery'),
    'description' 			=> __('Lista de galerías de la empresa'),
    'labels' 				=> $labels,
    'supports' 				=> array('title', 'excerpt', 'thumbnail'),
    'taxonomies' 			=> array(),
    'hierarchical' 			=> false,
    'public' 				=> true,
    'show_ui' 				=> true,
    'show_in_menu' 			=> true,
    'show_in_nav_menus' 	=> true,
    'show_in_admin_bar' 	=> true,
    'menu_position' 		=> 30,
    'can_export' 			=> true,
    'has_archive' 			=> false,
    'exclude_from_search' 	=> false,
    'capability_type' 		=> 'page',
    'menu_icon' 			=> 'dashicons-format-gallery',
    'publicly_queryable' 	=> true
  );
  register_post_type('product-gallery', $args);
}
add_action('init', 'cmc_create_cpt_gallery');


/*
|--------------------------------------------------------------------------
| Brands
|--------------------------------------------------------------------------
*/
function cmc_create_cpt_brands(){

  $labels = array(
    'name' 						=> __('Marcas'),
    'singular_name' 			=> __('Marca'),
    'menu_name' 				=> __('Marcas'),
    'name_admin_bar' 			=> __('Marcas'),
    'archives' 					=> __('Archivo de marcas'),
    'parent_item_colon' 		=> __('Marca padre:'),
    'all_items' 				=> __('Todos los elementos'),
    'add_new' 					=> __('Añadir nuevo'),
    'add_new_item' 				=> __('Añadir nuevo elemento'),
    'edit' 						=> __('Editar'),
    'edit_item' 				=> __('Editar marca'),
    'new_item' 					=> __('Nuevo marca'),
    'view' 						=> __('Ver'),
    'view_item' 				=> __('Ver marca'),
    'update_item' 				=> __('Actualizar marca'),
    'search_items' 				=> __('Buscar marca'),
    'not_found' 				=> __('No se ha encontrado ningún elemento que coincida'),
    'not_found_in_trash' 		=> __('No se ha encontrado ninguna marca que coincida en la papelera'),
    'featured_image' 			=> __('Imagen destacada'),
    'set_featured_image' 		=> __('Asignar imagen destacada'),
    'remove_featured_image' 	=> __('Quitar la imagen destacada'),
    'use_featured_image' 		=> __('Usar una imagen destacada'),
    'insert_into_item' 			=> __('Insertar en la marca'),
    'uploaded_to_this_item' 	=> __('Subido a esta marca'),
    'items_list' 				=> __('Lista de marcas'),
    'items_list_navigation' 	=> __('Navegación lista de marcas'),
    'filter_items_list' 		=> __('Filtrar lista de marcas')
  );

  $args = array(
    'label' 				=> __('brands'),
    'description' 			=> __('Lista de marcas'),
    'labels' 				=> $labels,
    'supports' 				=> array('title', 'editor', 'thumbnail', 'comments', 'page-attributes', 'revisions'),
    'taxonomies' 			=> array(),
    'hierarchical' 			=> false,
    'public' 				=> true,
    'show_ui' 				=> true,
    'show_in_menu' 			=> true,
    'show_in_nav_menus' 	=> true,
    'show_in_admin_bar' 	=> true,
    'menu_position' 		=> 29,
    'can_export' 			=> true,
    'has_archive' 			=> false,
    'exclude_from_search' 	=> false,
    'capability_type' 		=> 'page',
    'menu_icon' 			=> 'dashicons-screenoptions',
    'publicly_queryable' 	=> true,
    'rewrite' 				=> array('slug' => 'marca-cafeteras'),
    'show_in_rest' 			=> true
  );

  register_post_type('brands', $args);
}
add_action('init', 'cmc_create_cpt_brands');
