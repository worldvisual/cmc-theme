<?php 

/*
|--------------------------------------------------------------------------
| Cafeteras - CUSTOM POST TYPE
|--------------------------------------------------------------------------
*/
function cmc_create_cpt_main_product(){
	$labels = array(
		'name' => __('Cafeteras'),
		'singular_name' => __('Cafetera'),
		'menu_name' => __('Cafeteras'),
		'name_admin_bar' => __('Cafeteras'),
		'archives' => __('Archivo de cafeteras'),
		'parent_item_colon' => __('Cafetera padre:'),
		'all_items' => __('Todos los elementos'),
		'add_new' => __('Añadir nuevo'),
		'add_new_item' => __('Añadir nuevo elemento'),
		'edit' => __('Editar'),
		'edit_item' => __('Editar cafetera'),
		'new_item' => __('Nueva cafetera'),
		'view' => __('Ver'),
		'view_item' => __('Ver cafetera'),
		'update_item' => __('Actualizar cafetera'),
		'search_items' => __('Buscar cafeteras'),
		'not_found' => __('No se ha encontrado ningún elemento que coincida'),
		'not_found_in_trash' => __('No se ha encontrado ninguna cafetera que coincida en la papelera'),
		'featured_image' => __('Imagen destacada'),
		'set_featured_image' => __('Asignar imagen destacada'),
		'remove_featured_image' => __('Quitar la imagen destacada'),
		'use_featured_image' => __('Usar una imagen destacada'),
		'insert_into_item' => __('Insertar en la cafetera'),
		'uploaded_to_this_item' => __('Subido a esta cafetera'),
		'items_list' => __('Lista de cafeteras'),
		'items_list_navigation' => __('Navegación lista de cafeteras'),
		'filter_items_list' => __('Filtrar lista de cafeteras')
	);

	$args = array(
		'label' => __('main_product'),
		'description' => __('Lista de cafeteras'),
		'labels' => $labels,
		'supports' => array('title', 'editor', 'comments'),
		'taxonomies' => array(),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 26,
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => false,
		'capability_type' => 'page',
		'menu_icon' => get_template_directory_uri() . '/assets/images/icon/icon-dashboard-1.png',
		'publicly_queryable' => true,
		'rewrite' => array('slug' => 'cafeteras'),
		'show_in_rest' => true
	);

	register_post_type('main_product', $args);
}
add_action('init', 'cmc_create_cpt_main_product');


/*
|--------------------------------------------------------------------------
| Taxonomy
|--------------------------------------------------------------------------
*/
function cmc_create_mainproduct_taxonomy(){
	$labels = array(
		'name' => _x('Categorías Cafeteras', 'Taxonomy General Name'),
		'singular_name' => _x('Categoría Cafetera', 'Taxonomy Singular Name'),
		'menu_name' => __('Categoría Cafeteras'),
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
		'rewrite' => array('slug' => 'product-category')
	);

	register_taxonomy('product-category', array('main_product'), $args);
}
add_action('init', 'cmc_create_mainproduct_taxonomy', 0);


/*
|--------------------------------------------------------------------------
| Meta Box
|--------------------------------------------------------------------------
*/
function cmc_mainproduct_metabox(){
	add_meta_box('cmc_mainproduct_data', 'Datos del producto', 'cmc_mainproduct_metabox_design', 'main_product', 'normal', 'high', null);
}
add_action('add_meta_boxes', 'cmc_mainproduct_metabox');


function cmc_mainproduct_metabox_design($post){
	wp_nonce_field(basename(__FILE__), 'meta-box-nonce');
	?>
	<div>
		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('ASIN'); ?></label>
		<input name="cmc-mainproduct-asin" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-mainproduct-asin', true); ?>">
		<br />
		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Texto botón'); ?></label>
		<input name="cmc-mainproduct-button-text" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-mainproduct-button-text', true); ?>">
		<br />
	</div>
	<?php
}


function cmc_save_mainproduct_metabox($post_id, $post, $update){
	if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))
		return $post_id;
	if (!current_user_can('edit_post', $post_id))
		return $post_id;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	if (isset($_POST['cmc-mainproduct-asin'])) {
		update_post_meta($post_id, 'cmc-mainproduct-asin', $_POST['cmc-mainproduct-asin']);
	}
	if (isset($_POST['cmc-mainproduct-button-text'])) {
		update_post_meta($post_id, 'cmc-mainproduct-button-text', $_POST['cmc-mainproduct-button-text']);
	}
}
add_action('save_post', 'cmc_save_mainproduct_metabox', 10, 3);


/*
|--------------------------------------------------------------------------
| Compatibility with the old screen
|--------------------------------------------------------------------------
*/
function cmc_get_prodcut_data($postId, $postType){
	$data = array();
	switch ($postType) {
		case 'main_product':
      // process old screen //
		$current_specs = unserialize(get_post_meta($postId, '_uat_ama_specs', true));
		if (is_array($current_specs)) {
			foreach ($current_specs as $key => $subarray) {
				foreach ($subarray as $subkey => $subsubarray) {
					if ($subkey == 'spec_value') :
						$current_specs[$key][$subkey] = htmlspecialchars(stripslashes(base64_decode($subsubarray)));
					else :
						$current_specs[$key][$subkey] = htmlspecialchars(stripslashes($subsubarray));
					endif;
				}
			}
		}

		$temp_specs = get_option('uat_options_product');
		$_temp_specs = $temp_specs['uat_main_product_custom_specs'];
		if (!is_array($_temp_specs)) {
			$custom_options = unserialize($_temp_specs);
		} else {
			$custom_options = $_temp_specs;
		}

		$_groupings = $custom_options;
		$groupings = array();
		if (is_array($_groupings)) {
			foreach ($_groupings as $field => $group) {
				for ($i = 0; $i < count($group); $i++) {
					$groupings[$i][$field] = $group[$i];
				}
			}
		}

		$affiliate_link = '';
		$product_name = '';
		foreach ($groupings as $field => $grouping) {
			if ($grouping['uat_ama_spec_toggle'] == 'off') :
				$hide_show = ' inactive-spec';
			else :
				$hide_show = '';
			endif;

			$spec_value = '';
			foreach ($grouping as $value_name => $value) {
				if ($value_name == 'uat_ama_spec_meta_key') :
					if (is_array($current_specs)) :
						foreach ($current_specs as $field => $spec_meta_key) {
							if ($spec_meta_key['spec_meta_key'] == $grouping['uat_ama_spec_meta_key']) {
								$spec_value =  $spec_meta_key['spec_value'];
							}
						}
					endif;
          // first data block
				elseif ($value_name == 'uat_ama_spec_name') :
					if ($value == 'Product Affiliate Link') :
						$data['affiliate-link'] = $spec_value;
					endif;
					if ($value == 'Product Name') :
						$data['product-name'] = $spec_value;
					endif;
					if ($value != 'Product Affiliate Link' && $value != '' && $hide_show != ' inactive-spec' && $spec_value != '') :

						if ($value == 'Marca') :
							$data['brand'] = $spec_value;
						elseif ($value == 'Tipo') :
							$data['type'] = $spec_value;
						elseif ($value == 'Operación') :
							$data['transaction'] = $spec_value;
						elseif ($value == 'Capacidad') :
							$data['capacitance'] = $spec_value;
						elseif ($value == 'Rating') :
							$data['score'] = $spec_value;
							$data['score-stars'] = '';
							$data['score-stars-small'] = '';
						endif;
					endif;
				endif;
			}
		}
      // end old screen //

		for ($i = 1; $i <= $data['score']; $i++) {
			if (is_float($data['score'] + 0) && (($i + 0.5) == $data['score'])) {
				$data['score-stars-small'] .= '<i class="icon-star-small"></i><i class="icon-star-middle-small"></i>';
				$data['score-stars'] .= '<i class="icon-star"></i><i class="icon-star-middle"></i>';
				$i++;
			} else {
				$data['score-stars-small'] .= '<i class="icon-star-small"></i>';
				$data['score-stars'] .= '<i class="icon-star"></i>';
			}
		}
		for ($j = $i; $j <= 5; $j++) {
			$data['score-stars-small'] .= '<i class="icon-star-small-empty"></i>';
			$data['score-stars'] .= '<i class="icon-star-empty"></i>';
		}

		$main_prod_image = get_post_meta(get_the_ID(), '_main_product_img', true);
		$data['image'] = wp_get_attachment_image_src(esc_attr($main_prod_image), 'product-large')[0];
		$data['image-medium'] = wp_get_attachment_image_src(esc_attr($main_prod_image), 'product-medium')[0];
		$data['image-small'] = wp_get_attachment_image_src(esc_attr($main_prod_image), 'product-small')[0];
		break;

		case 'related_product_1':
		$data = unserialize(get_post_meta($postId, 'cmc-relatedproduct1-options', true));
		$data['image'] = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'product-large')[0];
		$data['image-medium'] = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'product-medium')[0];
		$data['image-small'] = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'product-small')[0];
		break;

		case 'related_product_2':
		$data = unserialize(get_post_meta($postId, 'cmc-relatedproduct2-options', true));
		$data['image'] = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'product-large')[0];
		$data['image-medium'] = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'product-medium')[0];
		$data['image-small'] = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'product-small')[0];
		break;
	}

  // second data block (common to all products)
	if ($postType == 'main_product')
		$data['asin'] = get_post_meta($postId, 'cmc-mainproduct-asin', true);
	else if ($postType == 'main_product')
		$data['asin'] = get_post_meta($postId, 'cmc-relatedproduct1-options', true)['asin'];
	else if ($postType == 'main_product')
		$data['asin'] = get_post_meta($postId, 'cmc-relatedproduct2-options', true)['asin'];
	if (!empty($data['asin'])) {
		$data['price'] = do_shortcode('[aawp fields="' . $data['asin'] . '" value="price"]');
		$data['price'] = (int)str_replace(',', '.', rtrim($data['price'], ' €'));
		$data['discount'] = 0;
		$data['available'] = '';
		$data['button-text'] = get_post_meta($postId, 'cmc-mainproduct-button-text', true);
		if ($data['price'] > 49.99) {
			$data['price'] = round($data['price']);
			$data['discount'] = round($data['discount']);
		}

		if (empty($data['button-text']) && $data['price'] == 0) {
			$data['button-text'] = __('Comprar AHORA');
		} else if (empty($data['button-text'])) {
			if (!empty($data['discount']) && $data['discount'] != 0) {
				$data['button-text'] = __('Comprar AHORA - ') . $data['price'] . ' €' . '<span class="old-price">' . ($data['price'] + $data['discount']) . ' €</span> ';
			} else {
				$data['button-text'] = __('Comprar AHORA - ') . $data['price'] . ' €';
			}
		} else {
			if (!empty($data['discount']) && $data['discount'] != 0) {
				$data['button-text'] = $data['button-text'] . ' - ' . $data['price'] . ' €' . '<span class="old-price">' . ($data['price'] + $data['discount']) . ' €</span> ';
			} else {
				$data['button-text'] = $data['button-text'] . ' - ' . $data['price'] . ' €';
			}
		}
	} else {

		$data['price'] = '';
		$data['discount'] = '';
		$data['available'] = 1;
		$data['button-text'] = get_post_meta($postId, 'cmc-mainproduct-button-text', true);

		if (empty($data['button-text'])) {
			$data['button-text'] = __('Comprar AHORA');
		} else {
			$data['button-text'] = $data['button-text'];
		}
	}
  // end

	return $data;
}


function cmc_related_products($post_type, $taxonomy, $term, $exclude){

	$args = array(
		'post__not_in' => array($exclude),
		'posts_per_page' => 3,
		'post_type' => $post_type,
		'orderby' => 'rand',
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'field' => 'slug',
				'terms' => $term
			)
		)
	);

	$query = new WP_Query($args);

	?>
	<div class="gallery">
		<?php
		while ($query->have_posts()) : $query->the_post();

			$data = cmc_get_prodcut_data(get_the_ID(), $post_type);
			?>
			<div class="product-gallery">
				<div class="gallery-img">
					<a href="<?php esc_url(get_the_permalink()); ?>">
						<img src="<?php esc_url($data['image']); ?>">
					</a>
				</div>
				<span class="gallery-name">
					<a href="<?php esc_url(get_the_permalink()); ?>">
						<?php esc_html_e(get_the_title()); ?>
					</a>
				</span>
				<div class="gallery-excerpt">
					<?php esc_html_e($data['type'] . ' - ' . $data['transaction'] . ' - ' . $data['capacitance']); ?>
				</div>
				<?php if (!empty($data['discount']) && $data['discount'] != 0) { ?>

					<span class="price-old">' . $data['price'] . '</span>
					<span class="price"><?php esc_html_e($data['price'] - $data['discount']); ?>€</span>
					
				<?php } ?>
			</div>

			<?php 
		endwhile;
		wp_reset_postdata(); 
		?>
	</div>
	<div class="clear"></div>
}


function cmc_get_products_by_id($id, $postType){

	$args = array(
	'posts_per_page' => -1,
	'post__in' => $id,
	'post_type' => $postType,
	'orderby' => 'date',
	'order' => 'DESC'
	);

	$query = new WP_Query($args);

	return $query;
}

function cmc_get_products_by_asin($asin, $postType){

	$args = array(
	'meta_query'  => array(
	array(
	'key' => 'cmc-mainproduct-asin',
	'value' => $asin,
	'compare' => 'IN'
	)

	),
	'post_type' => $postType,
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'DESC'
	);
	$query = new WP_Query($args);
	return $query;
}


/*
|--------------------------------------------------------------------------
| Molinillos - CUSTOM POST TYPE
|--------------------------------------------------------------------------
*/
function cmc_create_cpt_related_product_1(){

	$labels = array(
	'name' => __('Molinillos'),
	'singular_name' => __('Molinillo'),
	'menu_name' => __('Molinillos'),
	'name_admin_bar' => __('Molinillos'),
	'archives' => __('Archivo de molinillos'),
	'parent_item_colon' => __('Molinillo padre:'),
	'all_items' => __('Todos los elementos'),
	'add_new' => __('Añadir nuevo'),
	'add_new_item' => __('Añadir nuevo elemento'),
	'edit' => __('Editar'),
	'edit_item' => __('Editar molinillo'),
	'new_item' => __('Nuevo molinillo'),
	'view' => __('Ver'),
	'view_item' => __('Ver molinillo'),
	'update_item' => __('Actualizar molinillo'),
	'search_items' => __('Buscar molinillo'),
	'not_found' => __('No se ha encontrado ningún elemento que coincida'),
	'not_found_in_trash' => __('No se ha encontrado ningún molinillo que coincida en la papelera'),
	'featured_image' => __('Imagen destacada'),
	'set_featured_image' => __('Asignar imagen destacada'),
	'remove_featured_image' => __('Quitar la imagen destacada'),
	'use_featured_image' => __('Usar una imagen destacada'),
	'insert_into_item' => __('Insertar en el molinillo'),
	'uploaded_to_this_item' => __('Subido a este molinillo'),
	'items_list' => __('Lista de molinillos'),
	'items_list_navigation' => __('Navegación lista de molinillos'),
	'filter_items_list' => __('Filtrar lista de molinillos')
	);

	$args = array(
	'label' => __('related_product_1'),
	'description' => __('Lista de molinillos'),
	'labels' => $labels,
	'supports' => array('title', 'editor', 'thumbnail', 'comments'),
	'taxonomies' => array(),
	'hierarchical' => false,
	'public' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'show_in_nav_menus' => true,
	'show_in_admin_bar' => true,
	'menu_position' => 27,
	'can_export' => true,
	'has_archive' => false,
	'exclude_from_search' => false,
	'capability_type' => 'page',
	'menu_icon' => get_template_directory_uri() . '/assets/images/icon/icon-dashboard-1.png',
	'publicly_queryable' => true,
	'rewrite' => array('slug' => 'molinillos'),
	'show_in_rest' => true
	);

	register_post_type('related_product_1', $args);
}
add_action('init', 'cmc_create_cpt_related_product_1');


/*
|--------------------------------------------------------------------------
| Meta Box
|--------------------------------------------------------------------------
*/
function cmc_relatedproduct1_metabox(){
	add_meta_box('cmc_relatedproduct1_data', 'Información del producto', 'cmc_relatedproduct1_metabox_design', 'related_product_1', 'normal', 'high', null);
}
add_action('add_meta_boxes', 'cmc_relatedproduct1_metabox');


function cmc_relatedproduct1_metabox_design($post){

	wp_nonce_field(basename(__FILE__), 'meta-box-nonce');
	$cmc_relatedproduct1_options = get_post_meta($post->ID, 'cmc-relatedproduct1-options', true);
	if (empty($cmc_relatedproduct1_options))
	$cmc_relatedproduct1_options = array();
	else
	$cmc_relatedproduct1_options = unserialize($cmc_relatedproduct1_options);
?>

<div>
	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Nombre del producto'); ?></label>
	<input name="cmc-relatedproduct1-options[product-name]" type="text" value="<?php echo $cmc_relatedproduct1_options['product-name']; ?>">
	<br />
	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Enlace de afiliado'); ?></label>
	<input name="cmc-relatedproduct1-options[affiliate-link]" type="text" value="<?php echo $cmc_relatedproduct1_options['affiliate-link']; ?>">
	<br />
	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Marca'); ?></label>
	<input name="cmc-relatedproduct1-options[brand]" type="text" value="<?php echo $cmc_relatedproduct1_options['brand']; ?>">
	<br />
	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Operación'); ?></label>
	<input name="cmc-relatedproduct1-options[transaction]" type="text" value="<?php echo $cmc_relatedproduct1_options['transaction']; ?>">
	<br />
	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Capacidad'); ?></label>
	<input name="cmc-relatedproduct1-options[capacitance]" type="text" value="<?php echo $cmc_relatedproduct1_options['capacitance']; ?>">
	<br />
	<?php $score = $cmc_relatedproduct1_options['score']; ?>
	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Puntuación'); ?></label>
	<select name="cmc-relatedproduct1-options[score]">
		<option <?php echo selected($score, '', false); ?> value=""><?php _e('Seleccionar puntuación'); ?></option>
		<option <?php echo selected($score, '1', false); ?> value="1">1</option>
		<option <?php echo selected($score, '1.5', false); ?> value="1.5">1.5</option>
		<option <?php echo selected($score, '2', false); ?> value="2">2</option>
		<option <?php echo selected($score, '2.5', false); ?> value="2.5">2.5</option>
		<option <?php echo selected($score, '3', false); ?> value="3">3</option>
		<option <?php echo selected($score, '3.5', false); ?> value="3.5">3.5</option>
		<option <?php echo selected($score, '4', false); ?> value="4">4</option>
		<option <?php echo selected($score, '4.5', false); ?> value="4.5">4.5</option>
		<option <?php echo selected($score, '5', false); ?> value="5">5</option>
	</select>

	<br />

	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('ASIN'); ?></label>
	<input name="cmc-relatedproduct1-options[asin]" type="text" value="<?php echo $cmc_relatedproduct1_options['asin']; ?>">

	<br />

	<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Texto botón'); ?></label>
	<input name="cmc-relatedproduct1-options[button-text]" type="text" value="<?php echo $cmc_relatedproduct1_options['button-text']; ?>">

	<br />

</div>
<?php
}


function cmc_save_relatedproduct1_metabox($post_id, $post, $update){
	if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))
		return $post_id;
	if (!current_user_can('edit_post', $post_id))
		return $post_id;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

	if (isset($_POST['cmc-relatedproduct1-options'])) {
		update_post_meta($post_id, 'cmc-relatedproduct1-options', serialize($_POST['cmc-relatedproduct1-options']));
	}
}
add_action('save_post', 'cmc_save_relatedproduct1_metabox', 10, 3);


/*
|--------------------------------------------------------------------------
| Espumadores de leche - CUSTOM POST TYPE
|--------------------------------------------------------------------------
*/
function cmc_create_cpt_related_product_2(){

	$labels = array(
		'name' => __('Espumadores de Leche'),
		'singular_name' => __('Espumador'),
		'menu_name' => __('Espumadores de leche'),
		'name_admin_bar' => __('Espumadores de leche'),
		'archives' => __('Archivo de espumadores'),
		'parent_item_colon' => __('Espumador padre:'),
		'all_items' => __('Todos los elementos'),
		'add_new' => __('Añadir nuevo'),
		'add_new_item' => __('Añadir nuevo elemento'),
		'edit' => __('Editar'),
		'edit_item' => __('Editar espumador'),
		'new_item' => __('Nuevo espumador'),
		'view' => __('Ver'),
		'view_item' => __('Ver espumador'),
		'update_item' => __('Actualizar espumador'),
		'search_items' => __('Buscar espumador'),
		'not_found' => __('No se ha encontrado ningún elemento que coincida'),
		'not_found_in_trash' => __('No se ha encontrado ningún espumador que coincida en la papelera'),
		'featured_image' => __('Imagen destacada'),
		'set_featured_image' => __('Asignar imagen destacada'),
		'remove_featured_image' => __('Quitar la imagen destacada'),
		'use_featured_image' => __('Usar una imagen destacada'),
		'insert_into_item' => __('Insertar en el espumador'),
		'uploaded_to_this_item' => __('Subido a este espumador'),
		'items_list' => __('Lista de espumadores'),
		'items_list_navigation' => __('Navegación lista de espumadores'),
		'filter_items_list' => __('Filtrar lista de espumadores')
	);

	$args = array(
		'label' => __('related_product_2'),
		'description' => __('Lista de espumadores'),
		'labels' => $labels,
		'supports' => array('title', 'editor', 'thumbnail', 'comments'),
		'taxonomies' => array(),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 28,
		'can_export' => true,
		'has_archive' => false,
		'exclude_from_search' => false,
		'capability_type' => 'page',
		'menu_icon' => get_template_directory_uri() . '/assets/images/icon/icon-dashboard-1.png',
		'publicly_queryable' => true,
		'rewrite' => array('slug' => 'espumadores-de-leche'),
		'show_in_rest' => true
	);

	register_post_type('related_product_2', $args);
}
add_action('init', 'cmc_create_cpt_related_product_2');


/*
|--------------------------------------------------------------------------
| Meta Box
|--------------------------------------------------------------------------
*/
function cmc_relatedproduct2_metabox(){
	add_meta_box('cmc_relatedproduct2_data', 'Información del producto', 'cmc_relatedproduct2_metabox_design', 'related_product_2', 'normal', 'high', null);
}
add_action('add_meta_boxes', 'cmc_relatedproduct2_metabox');

function cmc_relatedproduct2_metabox_design($post){
	wp_nonce_field(basename(__FILE__), 'meta-box-nonce');

	$cmc_relatedproduct2_options = get_post_meta($post->ID, 'cmc-relatedproduct2-options', true);

	if (empty($cmc_relatedproduct2_options))
		$cmc_relatedproduct2_options = array();
	else
		$cmc_relatedproduct2_options = unserialize($cmc_relatedproduct2_options);
	?>

	<div>
		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Nombre del producto'); ?></label>
		<input name="cmc-relatedproduct2-options[product-name]" type="text" value="<?php echo $cmc_relatedproduct2_options['product-name']; ?>">

		<br />

		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Enlace de afiliado'); ?></label>
		<input name="cmc-relatedproduct2-options[affiliate-link]" type="text" value="<?php echo $cmc_relatedproduct2_options['affiliate-link']; ?>">

		<br />

		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Marca'); ?></label>
		<input name="cmc-relatedproduct2-options[brand]" type="text" value="<?php echo $cmc_relatedproduct2_options['brand']; ?>">

		<br />

		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Operación'); ?></label>
		<input name="cmc-relatedproduct2-options[transaction]" type="text" value="<?php echo $cmc_relatedproduct2_options['transaction']; ?>">

		<br />

		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Capacidad'); ?></label>
		<input name="cmc-relatedproduct2-options[capacitance]" type="text" value="<?php echo $cmc_relatedproduct2_options['capacitance']; ?>">

		<br />

		<?php $score = $cmc_relatedproduct2_options['score']; ?>
		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Puntuación'); ?></label>
		<select name="cmc-relatedproduct2-options[score]">
			<option <?php echo selected($score, '', false); ?> value=""><?php _e('Seleccionar puntuación'); ?></option>
			<option <?php echo selected($score, '1', false); ?> value="1">1</option>
			<option <?php echo selected($score, '1.5', false); ?> value="1.5">1.5</option>
			<option <?php echo selected($score, '2', false); ?> value="2">2</option>
			<option <?php echo selected($score, '2.5', false); ?> value="2.5">2.5</option>
			<option <?php echo selected($score, '3', false); ?> value="3">3</option>
			<option <?php echo selected($score, '3.5', false); ?> value="3.5">3.5</option>
			<option <?php echo selected($score, '4', false); ?> value="4">4</option>
			<option <?php echo selected($score, '4.5', false); ?> value="4.5">4.5</option>
			<option <?php echo selected($score, '5', false); ?> value="5">5</option>
		</select>

		<br />

		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('ASIN'); ?></label>
		<input name="cmc-relatedproduct2-options[asin]" type="text" value="<?php echo $cmc_relatedproduct2_options['asin']; ?>">

		<br />

		<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Texto botón'); ?></label>
		<input name="cmc-relatedproduct2-options[button-text]" type="text" value="<?php echo $cmc_relatedproduct2_options['button-text']; ?>">

		<br />

	</div>
	<?php
}


function cmc_save_relatedproduct2_metabox($post_id, $post, $update){

	if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))
		return $post_id;

	if (!current_user_can('edit_post', $post_id))
		return $post_id;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

	if (isset($_POST['cmc-relatedproduct2-options'])) {
		update_post_meta($post_id, 'cmc-relatedproduct2-options', serialize($_POST['cmc-relatedproduct2-options']));
	}
}
add_action('save_post', 'cmc_save_relatedproduct2_metabox', 10, 3);


/*
|--------------------------------------------------------------------------
| Rich snippets
|--------------------------------------------------------------------------
*/
function get_rich_snippets(){

	if (get_post_type() == 'main_product' || get_post_type() == 'related_product_1' || get_post_type() == 'related_product_2') {
		$data = cmc_get_prodcut_data(get_the_ID(), get_post_type());
		$score = $data['score'];
		$product = get_the_title();
		$ratingoutput = '<script type="application/ld+json">{"@context": "http://schema.org","@type": "Product","name": "' . $product . '","aggregateRating": {"@type": "AggregateRating","ratingValue": "' . $score . '"}}</script>';

		return $ratingoutput;
	} else
	return '';
}
