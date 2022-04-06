<?php

function cmc_gallery_data_metabox(){
  add_meta_box('cmc_gallery_data', 'Datos', 'cmc_gallery_data_metabox_design', 'product-gallery', 'normal', 'high', null);
}
add_action('add_meta_boxes', 'cmc_gallery_data_metabox');


function cmc_gallery_data_metabox_design($post){
  wp_nonce_field(basename(__FILE__), 'meta-box-nonce');
?>

  <div>
    <label for="input-metabox"><?php _e('Enlace:'); ?></label>
    <input name="cmc-gallery-url" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-gallery-url', true); ?>">
    <br />
    <label for="input-metabox"><?php _e('Precio:'); ?></label>
    <input name="cmc-gallery-price" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-gallery-price', true); ?>">
    <br />
  </div>
<?php
}


function cmc_gallery_data_metabox_save($post_id, $post, $update){

  if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))
    return $post_id;

  if (!current_user_can('edit_post', $post_id))
    return $post_id;

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return $post_id;

  if (isset($_POST['cmc-gallery-url'])) {
    update_post_meta($post_id, 'cmc-gallery-url', wp_filter_input('post', 'cmc-gallery-url'));
  }

  if (isset($_POST['cmc-gallery-price'])) {
    update_post_meta($post_id, 'cmc-gallery-price', wp_filter_input('post', 'cmc-gallery-price'));
  }
}
add_action('save_post', 'cmc_gallery_data_metabox_save', 10, 3);


function cmc_create_taxonomy_gallery(){
  $labels = array(
    'name' => _x('Categorías Galerías', 'Taxonomy General Name'),
    'singular_name' => _x('Categoría Galería', 'Taxonomy Singular Name'),
    'menu_name' => __('Categoría Galería'),
    'all_items' => __('Todas las categorías'),
    'parent_item' => __('Categoría padre'),
    'parent_item_colon' => __('Categoría padre:'),
    'new_item_name' => __('Nuevo nombre de categoría'),
    'add_new_item' => __('Añadir nueva categoría'),
    'edit_item' => __('Editar categoría'),
    'update_item' => __('Actualizar categoría'),
    'view_item' => __('Ver categoría'),
    'separate_items_with_commas' => __('Separar las categorías por comas'),
    'add_or_remove_items' => __('Añadir o eliminar categorías'),
    'choose_from_most_used' => __('Elija entre las más utilizadas'),
    'popular_items' => __('Categorías populares'),
    'search_items' => __('Buscar categorías'),
    'not_found' => __('No encontrado'),
    'no_terms' => __('No hay categorías'),
    'items_list' => __('Lista de categorías'),
    'items_list_navigation' => __('Navegación lista de categorías'),
  );

  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'public' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_tagcloud' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'gallery-category')
  );

  register_taxonomy('gallery-category', array('product-gallery'), $args);
}
add_action('init', 'cmc_create_taxonomy_gallery', 0);
