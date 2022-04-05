<?php
	include_once(get_template_directory().'/includes/old-template.php');

/* Add David, para quitar alternates /feed en el head */
function disable_all_feeds() {
	wp_die( __('Lo siento, nuestro contenido no está disponible mediante RSS. Por favor, visita <a href="'. get_bloginfo('url') .'">la web</a> para leerla') );
}

add_action('do_feed', 'wpb_disable_feed', 1);
add_action('do_feed_rdf', 'wpb_disable_feed', 1);
add_action('do_feed_rss', 'wpb_disable_feed', 1);
add_action('do_feed_rss2', 'wpb_disable_feed', 1);
add_action('do_feed_atom', 'wpb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
/* Fin Add David, para quitar alternates /feed en el head */

	/* Scripts and Styles */
/* Add David, para subir la CSS al header */
function cmc_scripts_header() {
		wp_enqueue_style('google-fonts-Lato', 'https://fonts.googleapis.com/css?family=Lato:300,400,700', false);
		wp_enqueue_style('google-fonts-Comfortaa', 'https://fonts.googleapis.com/css?family=Comfortaa:400', false);
		wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.min.css');
		wp_enqueue_style('cmc-style', get_stylesheet_uri(), array('normalize'), '1.0', 'all');
	}
add_action('wp_enqueue_scripts', 'cmc_scripts_header');
/* Fin Add David, para subir la CSS al header */

	function cmc_scripts() {
/* Comentado David para quitar css del pie
		wp_enqueue_style('google-fonts-Lato', 'https://fonts.googleapis.com/css?family=Lato:300,400,700', false);
		wp_enqueue_style('google-fonts-Comfortaa', 'https://fonts.googleapis.com/css?family=Comfortaa:400', false);
		wp_enqueue_style('normalize', get_template_directory_uri() . '/css/normalize.min.css');
		wp_enqueue_style('cmc-style', get_stylesheet_uri(), array('normalize'), '1.0', 'all');
*/
		wp_enqueue_script('wp-embed');
		wp_enqueue_script('cmc-global-js', get_template_directory_uri().'/js/global.js', array('jquery'), '1.0', false);
		wp_localize_script('cmc-global-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
		if(is_tax('product-category') || is_page_template('template-cafeteras.php') || is_page_template('template-molinillos.php') || is_page_template('template-espumadores-de-leche.php')) {
			wp_enqueue_script('cmc-taxonomy-js', get_template_directory_uri().'/js/taxonomy.js', array('jquery'), '1.0', false);
			wp_localize_script('cmc-taxonomy-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
		}
		if (is_singular() && comments_open() && get_option('thread_comments')) wp_enqueue_script( 'comment-reply' );
	}
	add_action('wp_footer', 'cmc_scripts');

	function cmc_jquery() {
		wp_dequeue_script('jquery');
		wp_dequeue_script('jquery-core');
		wp_dequeue_script('jquery-migrate');
		wp_enqueue_script('jquery', false, array(), false, true);
		wp_enqueue_script('jquery-core', false, array(), false, true);
		wp_enqueue_script('jquery-migrate', false, array(), false, true);
	}
	add_action('wp_enqueue_scripts', 'cmc_jquery');

	/* Setup */
	function cmc_setup() {
		register_nav_menus(
			array('header_menu' => __('Menú cabecera'),
			'menu_404_1' => __('Primer menú 404'),
			'menu_404_2' => __('Segundo menú 404'),
			'menu_404_3' => __('Tercer menú 404'))
		);

		add_post_type_support('page', 'excerpt');
		add_post_type_support('post', 'excerpt');
		remove_filter('the_excerpt', 'wpautop');
		add_theme_support('post-thumbnails');
		add_image_size('post-list-thumbnail', 170, 170, true);
		add_image_size('post-thumbnail', 839, 472, true);
		add_image_size('product-large', 1000, 1000, true);
		add_image_size('product-medium', 300, 300, true);
		add_image_size('product-small', 75, 75, true);
		add_image_size('gallery-thumbnail', 300, 338, true);
	}
	add_action('after_setup_theme', 'cmc_setup');

	/* Widgets */
	function cmc_widgets() {
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
			'before_title' => '<h4>',
			'after_title' => '</h4>'
		));
		register_sidebar(array(
			'name' => 'Footer Widgets - Columna 2',
			'id' => 'footer-widgets-2',
			'description' => __('Widgets para la columna 2 del footer'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>'
		));

		register_sidebar(array(
			'name' => 'Footer Widgets - Columna 3',
			'id' => 'footer-widgets-3',
			'description' => __('Widgets para la columna 3 del footer'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>'
		));
	}
	add_action('widgets_init', 'cmc_widgets');


	function cmc_replace_year ($text) {
	    return str_replace('%anio%', date('Y'), $text);
	}

	add_filter('the_title', 'cmc_replace_year', 999);
	add_filter('the_content', 'cmc_replace_year', 999);
	add_filter('wpseo_title', 'cmc_replace_year', 999);
	add_filter('wpseo_metadesc', 'cmc_replace_year', 999);


	/* Cafeteras */
	//CPT
	function cmc_create_cpt_main_product() {
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
			'menu_icon' => get_template_directory_uri().'/img/icon/icon-dashboard-1.png',
			'publicly_queryable' => true,
			'rewrite' => array('slug' => 'cafeteras'),
			'show_in_rest' => true
		);

		register_post_type('main_product', $args);
	}
	add_action('init', 'cmc_create_cpt_main_product');

	include_once(get_template_directory().'/includes/meta-boxes-main_product.php');

	//Taxonomy
	function cmc_create_mainproduct_taxonomy() {
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

	/* Meta Box */
	function cmc_mainproduct_metabox() {
		add_meta_box('cmc_mainproduct_data', 'Datos del producto', 'cmc_mainproduct_metabox_design', 'main_product', 'normal', 'high', null);
	}
	add_action('add_meta_boxes', 'cmc_mainproduct_metabox');

	function cmc_mainproduct_metabox_design($post) {
		wp_nonce_field(basename(__FILE__), 'meta-box-nonce');
		?>
			<div>
				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('ASIN'); ?></label>
				<input name="cmc-mainproduct-asin" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-mainproduct-asin', true); ?>">
				<br/>
				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Texto botón'); ?></label>
				<input name="cmc-mainproduct-button-text" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-mainproduct-button-text', true); ?>">
				<br/>
			</div>
		<?php
	}

	function cmc_save_mainproduct_metabox($post_id, $post, $update) {
		if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))
			return $post_id;
		if(!current_user_can('edit_post', $post_id))
			return $post_id;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;
		if(isset($_POST['cmc-mainproduct-asin'])) {
	    	update_post_meta($post_id, 'cmc-mainproduct-asin', $_POST['cmc-mainproduct-asin']);
		}
		if(isset($_POST['cmc-mainproduct-button-text'])) {
	    	update_post_meta($post_id, 'cmc-mainproduct-button-text', $_POST['cmc-mainproduct-button-text']);
		}
	}
	add_action('save_post', 'cmc_save_mainproduct_metabox', 10, 3);

	//Compatibilidad con antigua plantilla
	function cmc_get_prodcut_data($postId, $postType) {
		$data = array();
		switch($postType) {
			case 'main_product':
				// PROCESO ANTIGUA PLANTILLA //
				$current_specs = unserialize(get_post_meta($postId, '_uat_ama_specs', true));
				if(is_array($current_specs)) {
					foreach($current_specs as $key => $subarray) {
						foreach($subarray as $subkey => $subsubarray) {
							if($subkey=='spec_value'):
								$current_specs[$key][$subkey] = htmlspecialchars(stripslashes(base64_decode($subsubarray)));
							else: 
								$current_specs[$key][$subkey] = htmlspecialchars(stripslashes($subsubarray));
							endif;
						}
					}
				}

				$temp_specs = get_option('uat_options_product');
				$_temp_specs = $temp_specs['uat_main_product_custom_specs'];
				if(!is_array($_temp_specs)) {
					$custom_options = unserialize($_temp_specs);
				} else {
					$custom_options = $_temp_specs;
				}

				$_groupings = $custom_options;
				$groupings = array();
				if(is_array($_groupings)) {
					foreach ($_groupings as $field => $group) {
						for ($i=0; $i<count($group); $i++) {
							$groupings[$i][$field] = $group[$i];
						}
					}
				}

				$affiliate_link='';
				$product_name='';
				foreach ($groupings as $field => $grouping) {
					if($grouping['uat_ama_spec_toggle'] == 'off'):
						$hide_show = ' inactive-spec';
					else:
						$hide_show = '';
					endif;

					$spec_value = '';
					foreach ($grouping as $value_name => $value){
						if($value_name == 'uat_ama_spec_meta_key'):
							if (is_array($current_specs)) :
								foreach ($current_specs as $field => $spec_meta_key) {
									if($spec_meta_key['spec_meta_key'] == $grouping['uat_ama_spec_meta_key']){
										$spec_value =  $spec_meta_key['spec_value'];
									}
								}
							endif;
						//PRIMER BLOQUE DE DATOS
						elseif($value_name == 'uat_ama_spec_name'):
							if($value=='Product Affiliate Link'):
								$data['affiliate-link']=$spec_value;
							endif;
							if($value=='Product Name'):
								$data['product-name']=$spec_value;
							endif;
							if($value!='Product Affiliate Link' && $value != '' && $hide_show != ' inactive-spec' && $spec_value != ''):

								if($value=='Marca'):
									$data['brand'] = $spec_value;
								elseif($value=='Tipo'):
									$data['type'] = $spec_value;
								elseif($value=='Operación'):
									$data['transaction'] = $spec_value;
								elseif($value=='Capacidad'):
									$data['capacitance'] = $spec_value;
								elseif($value=='Rating'):
									$data['score'] = $spec_value;
									$data['score-stars'] = '';
									$data['score-stars-small'] = '';
								endif;
							endif;
						endif;
					}
				}
				// FIN PROCESO ANTIGUA PLANTILLA //

				for($i = 1; $i <= $data['score']; $i++) {
					if(is_float($data['score']+0) && (($i+0.5) == $data['score'])) {
						$data['score-stars-small'] .= '<i class="icon-star-small"></i><i class="icon-star-middle-small"></i>';
						$data['score-stars'] .= '<i class="icon-star"></i><i class="icon-star-middle"></i>';
						$i++;
					}
					else {
						$data['score-stars-small'] .= '<i class="icon-star-small"></i>';
						$data['score-stars'] .= '<i class="icon-star"></i>';
					}
				}
				for($j = $i; $j <= 5; $j++) {
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

		// SEGUNDO BLOQUE DE DATOS (comunes todos los productos)
		if($postType == 'main_product')
			$data['asin'] = get_post_meta($postId, 'cmc-mainproduct-asin', true);
		else if($postType == 'main_product')
			$data['asin'] = get_post_meta($postId, 'cmc-relatedproduct1-options', true)['asin'];
		else if($postType == 'main_product')
			$data['asin'] = get_post_meta($postId, 'cmc-relatedproduct2-options', true)['asin'];
		if(!empty($data['asin'])) {
			//$cmc_amazon_info = cmc_amazon_get_data($data['asin']);
			//$data['price'] = $cmc_amazon_info['price'];
			$data['price'] = do_shortcode('[aawp fields="' . $data['asin'] . '" value="price"]');
			$data['price'] = (int)str_replace(',', '.', rtrim($data['price'], ' €'));
			//$data['discount'] = $cmc_amazon_info['discount'];
			$data['discount'] = 0;
			//$data['available'] = $cmc_amazon_info['available'];
			$data['available'] = '';
			$data['button-text'] = get_post_meta($postId, 'cmc-mainproduct-button-text', true);
			if($data['price'] > 49.99) {
				$data['price'] = round($data['price']);
				$data['discount'] = round($data['discount']);
			}

			if(empty($data['button-text']) && $data['price'] == 0) {
					$data['button-text'] = __('Comprar AHORA');
			}
			else if(empty($data['button-text'])) {
				if(!empty($data['discount']) && $data['discount'] != 0) {
					$data['button-text'] = __('Comprar AHORA - ') . $data['price'] . ' €' . '<span class="old-price">' . ($data['price'] + $data['discount']) . ' €</span> ';
				}
				else {
					$data['button-text'] = __('Comprar AHORA - ') . $data['price'] . ' €';
				}
			}
			else {
				if(!empty($data['discount']) && $data['discount'] != 0) {
					$data['button-text'] = $data['button-text'] . ' - ' . $data['price'] . ' €' . '<span class="old-price">' . ($data['price'] + $data['discount']) . ' €</span> ';
				}
				else {
					$data['button-text'] = $data['button-text'] . ' - ' . $data['price'] . ' €';
				}

			}

		}

		else {

			$data['price'] = '';

			$data['discount'] = '';

			$data['available'] = 1;

			$data['button-text'] = get_post_meta($postId, 'cmc-mainproduct-button-text', true);

			if(empty($data['button-text'])) {

				$data['button-text'] = __('Comprar AHORA');

			}

			else {

				$data['button-text'] = $data['button-text'];

			}

		}

		// FIN

		return $data;

	}

	function cmc_related_products($post_type, $taxonomy, $term, $exclude) {

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

		$result = '<div class="gallery">';

		while($query->have_posts()): $query->the_post();

			$data = cmc_get_prodcut_data(get_the_ID(), $post_type);

			$result .= '<div class="product-gallery">

						<div class="gallery-img"><a href="' . get_the_permalink() . '"><img src="' . $data['image'] . '"></a></div>

						<span class="gallery-name"><a href="' .  get_the_permalink() . '">' . get_the_title() . '</a></span>

						<div class="gallery-excerpt">' . $data['type'] . ' - ' . $data['transaction'] . ' - ' . $data['capacitance'] . '</div>';

			if(!empty($data['discount']) && $data['discount'] != 0) {
				$result .= '<span class="price-old">' . $data['price'] . '</span>';
				$result .= '<span class="price">' . ($data['price'] - $data['discount']) . '€</span>';
			}

			$result .= '</div>';

		endwhile; wp_reset_postdata();

		$result .= '</div><div class="clear"></div>';

		return $result;

	}

	function cmc_get_products_by_id($id, $postType) {

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

	function cmc_get_products_by_asin($asin, $postType) {

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

	/* Molinillos */

	//CPT

	function cmc_create_cpt_related_product_1() {

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

			'menu_icon' => get_template_directory_uri().'/img/icon/icon-dashboard-1.png',

			'publicly_queryable' => true,

			'rewrite' => array('slug' => 'molinillos'),

			'show_in_rest' => true

		);

		register_post_type('related_product_1', $args);

	}

	add_action('init', 'cmc_create_cpt_related_product_1');

	/* Meta Box */

	function cmc_relatedproduct1_metabox() {

		add_meta_box('cmc_relatedproduct1_data', 'Información del producto', 'cmc_relatedproduct1_metabox_design', 'related_product_1', 'normal', 'high', null);

	}

	add_action('add_meta_boxes', 'cmc_relatedproduct1_metabox');

	function cmc_relatedproduct1_metabox_design($post) {

		wp_nonce_field(basename(__FILE__), 'meta-box-nonce');

		?>

			<?php

				$cmc_relatedproduct1_options = get_post_meta($post->ID, 'cmc-relatedproduct1-options', true);

				if(empty($cmc_relatedproduct1_options))

					$cmc_relatedproduct1_options = array();

				else

					$cmc_relatedproduct1_options = unserialize($cmc_relatedproduct1_options);

			?>

			<div>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Nombre del producto'); ?></label>

				<input name="cmc-relatedproduct1-options[product-name]" type="text" value="<?php echo $cmc_relatedproduct1_options['product-name']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Enlace de afiliado'); ?></label>

				<input name="cmc-relatedproduct1-options[affiliate-link]" type="text" value="<?php echo $cmc_relatedproduct1_options['affiliate-link']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Marca'); ?></label>

				<input name="cmc-relatedproduct1-options[brand]" type="text" value="<?php echo $cmc_relatedproduct1_options['brand']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Operación'); ?></label>

				<input name="cmc-relatedproduct1-options[transaction]" type="text" value="<?php echo $cmc_relatedproduct1_options['transaction']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Capacidad'); ?></label>

				<input name="cmc-relatedproduct1-options[capacitance]" type="text" value="<?php echo $cmc_relatedproduct1_options['capacitance']; ?>">

				<br/>

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

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('ASIN'); ?></label>

				<input name="cmc-relatedproduct1-options[asin]" type="text" value="<?php echo $cmc_relatedproduct1_options['asin']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Texto botón'); ?></label>

				<input name="cmc-relatedproduct1-options[button-text]" type="text" value="<?php echo $cmc_relatedproduct1_options['button-text']; ?>">

				<br/>

			</div>

		<?php

	}



	function cmc_save_relatedproduct1_metabox($post_id, $post, $update) {

		if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))

			return $post_id;



		if(!current_user_can('edit_post', $post_id))

			return $post_id;



		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)

			return $post_id;



		if(isset($_POST['cmc-relatedproduct1-options'])) {

			update_post_meta($post_id, 'cmc-relatedproduct1-options', serialize($_POST['cmc-relatedproduct1-options']));

		}

	}

	add_action('save_post', 'cmc_save_relatedproduct1_metabox', 10, 3);



	/* Espumadores de leche */

	//CPT

	function cmc_create_cpt_related_product_2() {

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

			'menu_icon' => get_template_directory_uri().'/img/icon/icon-dashboard-1.png',

			'publicly_queryable' => true,

			'rewrite' => array('slug' => 'espumadores-de-leche'),

			'show_in_rest' => true

		);



		register_post_type('related_product_2', $args);

	}

	add_action('init', 'cmc_create_cpt_related_product_2');



	/* Meta Box */

	function cmc_relatedproduct2_metabox() {

		add_meta_box('cmc_relatedproduct2_data', 'Información del producto', 'cmc_relatedproduct2_metabox_design', 'related_product_2', 'normal', 'high', null);

	}

	add_action('add_meta_boxes', 'cmc_relatedproduct2_metabox');



	function cmc_relatedproduct2_metabox_design($post) {

		wp_nonce_field(basename(__FILE__), 'meta-box-nonce');

		?>

			<?php

				$cmc_relatedproduct2_options = get_post_meta($post->ID, 'cmc-relatedproduct2-options', true);

				if(empty($cmc_relatedproduct2_options))

					$cmc_relatedproduct2_options = array();

				else

					$cmc_relatedproduct2_options = unserialize($cmc_relatedproduct2_options);

			?>

			<div>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Nombre del producto'); ?></label>

				<input name="cmc-relatedproduct2-options[product-name]" type="text" value="<?php echo $cmc_relatedproduct2_options['product-name']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Enlace de afiliado'); ?></label>

				<input name="cmc-relatedproduct2-options[affiliate-link]" type="text" value="<?php echo $cmc_relatedproduct2_options['affiliate-link']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Marca'); ?></label>

				<input name="cmc-relatedproduct2-options[brand]" type="text" value="<?php echo $cmc_relatedproduct2_options['brand']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Operación'); ?></label>

				<input name="cmc-relatedproduct2-options[transaction]" type="text" value="<?php echo $cmc_relatedproduct2_options['transaction']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Capacidad'); ?></label>

				<input name="cmc-relatedproduct2-options[capacitance]" type="text" value="<?php echo $cmc_relatedproduct2_options['capacitance']; ?>">

				<br/>

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

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('ASIN'); ?></label>

				<input name="cmc-relatedproduct2-options[asin]" type="text" value="<?php echo $cmc_relatedproduct2_options['asin']; ?>">

				<br/>

				<label style="width:100px;display:inline-block;" for="input-metabox"><?php _e('Texto botón'); ?></label>

				<input name="cmc-relatedproduct2-options[button-text]" type="text" value="<?php echo $cmc_relatedproduct2_options['button-text']; ?>">

				<br/>

			</div>

		<?php

	}



	function cmc_save_relatedproduct2_metabox($post_id, $post, $update) {

		if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))

			return $post_id;



		if(!current_user_can('edit_post', $post_id))

			return $post_id;



		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)

			return $post_id;



		if(isset($_POST['cmc-relatedproduct2-options'])) {

			update_post_meta($post_id, 'cmc-relatedproduct2-options', serialize($_POST['cmc-relatedproduct2-options']));

		}

	}

	add_action('save_post', 'cmc_save_relatedproduct2_metabox', 10, 3);



	/* Marcas */

	function cmc_create_cpt_brands() {

		$labels = array(

			'name' => __('Marcas'),

			'singular_name' => __('Marca'),

			'menu_name' => __('Marcas'),

			'name_admin_bar' => __('Marcas'),

			'archives' => __('Archivo de marcas'),

            'parent_item_colon' => __('Marca padre:'),

			'all_items' => __('Todos los elementos'),

			'add_new' => __('Añadir nuevo'),

			'add_new_item' => __('Añadir nuevo elemento'),

			'edit' => __('Editar'),

			'edit_item' => __('Editar marca'),

            'new_item' => __('Nuevo marca'),

            'view' => __('Ver'),

            'view_item' => __('Ver marca'),

            'update_item' => __('Actualizar marca'),

            'search_items' => __('Buscar marca'),

            'not_found' => __('No se ha encontrado ningún elemento que coincida'),

            'not_found_in_trash' => __('No se ha encontrado ninguna marca que coincida en la papelera'),

            'featured_image' => __('Imagen destacada'),

            'set_featured_image' => __('Asignar imagen destacada'),

            'remove_featured_image' => __('Quitar la imagen destacada'),

            'use_featured_image' => __('Usar una imagen destacada'),

            'insert_into_item' => __('Insertar en la marca'),

            'uploaded_to_this_item' => __('Subido a esta marca'),

            'items_list' => __('Lista de marcas'),

            'items_list_navigation' => __('Navegación lista de marcas'),

            'filter_items_list' => __('Filtrar lista de marcas')

		);



		$args = array(

			'label' => __('brands'),

			'description' => __('Lista de marcas'),

			'labels' => $labels,

			'supports' => array('title', 'editor', 'thumbnail', 'comments'),

			'taxonomies' => array(),

			'hierarchical' => false,

			'public' => true,

			'show_ui' => true,

			'show_in_menu' => true,

			'show_in_nav_menus' => true,

			'show_in_admin_bar' => true,

			'menu_position' => 29,

			'can_export' => true,

			'has_archive' => false,

			'exclude_from_search' => false,

			'capability_type' => 'page',

			'menu_icon' => 'dashicons-screenoptions',

			'publicly_queryable' => true,

			'rewrite' => array('slug' => 'marca-cafeteras'),

			'show_in_rest' => true

		);



		register_post_type('brands', $args);

	}

	add_action('init', 'cmc_create_cpt_brands');



	include_once(get_template_directory().'/includes/meta-boxes-brands.php');



	/* Gallery */

	//CPT

	function cmc_create_cpt_gallery() {

		$labels = array(

			'name' => __('Galerías'),

			'singular_name' => __('Galería'),

			'menu_name' => __('Galerías'),

			'name_admin_bar' => __('Galerías'),

			'archives' => __('Archivo de galerías'),

            'parent_item_colon' => __('Galería padre:'),

			'all_items' => __('Todos los elementos'),

			'add_new' => __('Añadir nuevo'),

			'add_new_item' => __('Añadir nuevo elemento'),

			'edit' => __('Editar'),

			'edit_item' => __('Editar galería'),

            'new_item' => __('Nueva galería'),

            'view' => __('Ver'),

            'view_item' => __('Ver galería'),

            'update_item' => __('Actualizar galería'),

            'search_items' => __('Buscar galerías'),

            'not_found' => __('No se ha encontrado ningún elemento que coincida'),

            'not_found_in_trash' => __('No se ha encontrado ninguna galería que coincida en la papelera'),

            'featured_image' => __('Imagen destacada'),

            'set_featured_image' => __('Asignar imagen destacada'),

            'remove_featured_image' => __('Quitar la imagen destacada'),

            'use_featured_image' => __('Usar una imagen destacada'),

            'insert_into_item' => __('Insertar en la galería'),

            'uploaded_to_this_item' => __('Subido a esta galería'),

            'items_list' => __('Lista de galerías'),

            'items_list_navigation' => __('Navegación lista de galerías'),

            'filter_items_list' => __('Filtrar lista de galerías')

		);



		$args = array(

			'label' => __('product-gallery'),

			'description' => __('Lista de galerías de la empresa'),

			'labels' => $labels,

			'supports' => array('title', 'excerpt', 'thumbnail'),

			'taxonomies' => array(),

			'hierarchical' => false,

			'public' => true,

			'show_ui' => true,

			'show_in_menu' => true,

			'show_in_nav_menus' => true,

			'show_in_admin_bar' => true,

			'menu_position' => 30,

			'can_export' => true,

			'has_archive' => false,

			'exclude_from_search' => false,

			'capability_type' => 'page',

			'menu_icon' => 'dashicons-format-gallery',

			'publicly_queryable' => true

		);



		register_post_type('product-gallery', $args);

	}

	add_action('init', 'cmc_create_cpt_gallery');



	//Meta Box

	function cmc_gallery_data_metabox() {

		add_meta_box('cmc_gallery_data', 'Datos', 'cmc_gallery_data_metabox_design', 'product-gallery', 'normal', 'high', null);

	}

	add_action('add_meta_boxes', 'cmc_gallery_data_metabox');



	function cmc_gallery_data_metabox_design($post) {

		wp_nonce_field(basename(__FILE__), 'meta-box-nonce');

		?>

			<div>

				<label for="input-metabox"><?php _e('Enlace:'); ?></label>

				<input name="cmc-gallery-url" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-gallery-url', true); ?>">

				<br/>

				<label for="input-metabox"><?php _e('Precio:'); ?></label>

				<input name="cmc-gallery-price" type="text" value="<?php echo get_post_meta($post->ID, 'cmc-gallery-price', true); ?>">

				<br/>

			</div>

		<?php

	}



	function cmc_gallery_data_metabox_save($post_id, $post, $update) {

		if (!isset($_POST['meta-box-nonce']) || !wp_verify_nonce($_POST['meta-box-nonce'], basename(__FILE__)))

			return $post_id;



		if(!current_user_can('edit_post', $post_id))

			return $post_id;



		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)

			return $post_id;



		if(isset($_POST['cmc-gallery-url'])) {

	    	update_post_meta($post_id, 'cmc-gallery-url', $_POST['cmc-gallery-url']);

		}



		if(isset($_POST['cmc-gallery-price'])) {

	    	update_post_meta($post_id, 'cmc-gallery-price', $_POST['cmc-gallery-price']);

		}

	}

	add_action('save_post', 'cmc_gallery_data_metabox_save', 10, 3);



	//Taxonomy

	function cmc_create_taxonomy_gallery() {

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



	/* Tables */

	function cmc_comparative_box($atts, $content = '') {

		if(!empty($atts['asin'])) {

			$query = cmc_get_products_by_asin(explode(',', $atts['asin']), 'main_product');

		}

		else {

			$query = cmc_get_products_by_id(explode(',', $atts['id']), 'main_product');

		}

		$result = '<div class="table comparative-box">

					<h2 class="table-title">' . $atts['title'] . '</h2>

						<table>

							<tr>

								<th class="no-orderly">' . __('Imagen') . '</th>

								<th class="orderly">' . __('Cafetera') . '</th>

								<th class="no-orderly">' . __('Saber más') . '</th>

								<th class="orderly">' . __('Marca') . '</th>

								<th class="orderly">' . __('Tipo') . '</th>

								<th class="orderly">' . __('Operación') . '</th>

								<th class="orderly">' . __('Capacidad') . '</th>

								<th class="orderly">' . __('Valoración') . '</th>

							</tr>';

		while($query->have_posts()): $query->the_post();

			$data = cmc_get_prodcut_data(get_the_ID(), get_post_type());

			$result .= '<tr>

							<td><img class="comparative-box-img" src="' . $data['image-small'] . '"></td>

							<td class="comparative-box-name">' . get_the_title() . '</td>

							<td><a rel="nofollow" class="button" href="' . $data['affiliate-link'] . '">' . $data['button-text'] . '</a><a target="_blank" class="button-2" href="' . get_the_permalink() . '">' . __('Leer análisis') . '</a></td>

							<td>' . $data['brand'] . '</td>

							<td>' . $data['type'] . '</td>

							<td>' . $data['transaction'] . '</td>

							<td>' . $data['capacitance'] . '</td>

							<td><span class="hidden">' . $data['score'] . '</span>' . $data['score-stars'] . '</td>

						</tr>';

		endwhile; wp_reset_postdata();

		$result .= '</table>

				</div>';



		return $result;

	}

	add_shortcode('cmc-comparative-box', 'cmc_comparative_box');



	function cmc_list_products_box($atts, $content = '') {

		if(!empty($atts['asin'])) {

			$query = cmc_get_products_by_asin(explode(',', $atts['asin']), 'main_product');

		}

		else {

			$query = cmc_get_products_by_id(explode(',', $atts['id']), 'main_product');

		}

		$result = '<div class="list-products-box">';

		while($query->have_posts()): $query->the_post();

			$data = cmc_get_prodcut_data(get_the_ID(), get_post_type());

			$result .= '<div class="list-product-box">

							<div class="list-products-box-image"><img class="comparative-box-img" src="' . $data['image-small'] . '"></div>

							<div class="list-products-box-data">

								<span>' . get_the_title() . '</span>

								<span>' . __('Desde') . ' ' . $data['price'] . '€</span>

								<i class="icon-amazon"></i>

							</div>

							<div class="list-products-box-price">';

			if(!empty($data['discount']) && $data['discount'] != 0) {

				$result .= '<span class="price-old">' . $data['price'] . '</span>';

				$result .= '<span class="price">' . ($data['price'] - $data['discount']) . '€</span>';

			}

			else {

				$result .= '<span class="price">' . $data['price'] . '€</span>';

			}

			$result .= '<a rel="nofollow" href="' . $data['affiliate-link'] . '" class="button">' . __('Comprar AHORA') . '</a>

							</div>

						</div>';

		endwhile; wp_reset_postdata();

		$result .= '</div><div class="clear"></div>';



		return $result;

	}

	add_shortcode('cmc-list-products-box', 'cmc_list_products_box');



	function cmc_carousel($atts, $content = '') {

		if(!empty($atts['asin'])) {

			$query = cmc_get_products_by_asin(explode(',', $atts['asin']), 'main_product');

		}

		else {

			$query = cmc_get_products_by_id(explode(',', $atts['id']), 'main_product');

		}



		$result = '<div class="carousel">

						<h2 class="table-title">' . $atts['title'] . ' <span class="carousel-next">&#62;</span><span class="carousel-prev">&#60;</span><div class="clear"></div></h2>

						<div class="carousel-data">';

		while($query->have_posts()): $query->the_post();

			$data = cmc_get_prodcut_data(get_the_ID(), get_post_type());

			$result .= '<div class="carousel-product">

							<span class="carousel-name">' . get_the_title() . '</span>

							<div class="carousel-img"><img src="' . $data['image-small'] . '"></div>

							<a rel="nofollow" href="' . $data['affiliate-link'] . '" class="button">' . __('Comprar por') . ' ' . $data['price'] . '€</a>

						</div>';

		endwhile; wp_reset_postdata();

		$result .= '</div>

				</div><div class="clear"></div>';



		return $result;

	}

	add_shortcode('cmc-carousel', 'cmc_carousel');



	/* List Category Products */

	function cmc_category($atts, $content = '') {

		$args = array(

			'posts_per_page' => $atts['num'],

			'post_type' => 'main_product',

			'orderby' => 'date',

			'order' => 'DESC',

			'tax_query' => array(

				array(

					'taxonomy' => 'product-category',

					'field' => 'slug',

					'terms' => $atts['cat']

				)

			)

		);

		$query = new WP_Query($args);



		$result = '<div class="list-products">';

		while($query->have_posts()): $query->the_post();

			$data = cmc_get_prodcut_data(get_the_ID(), get_post_type());

			$result .= '<div class="product">

							<a target="_blank" href="' . get_the_permalink() . '"><img src="' . $data['image-medium'] . '"></a>

							<h2><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>

							<div class="price">' . (!empty($data['price'])?$data['price'].'€':'') . '</div>

						</div>';

		endwhile; wp_reset_postdata();

		$result .= '</div><div class="clear"></div>';



		return $result;

	}

	add_shortcode('cmc-category', 'cmc_category');

	function cmc_gallery($atts, $content = '') {

		$args = array(

			'posts_per_page' => $atts['num'],

			'post_type' => 'product-gallery',

			'orderby' => 'date',

			'order' => 'DESC',

			'tax_query' => array(

				array(

					'taxonomy' => 'gallery-category',

					'field' => 'slug',

					'terms' => $atts['cat']

				)

			)

		);

		$query = new WP_Query($args);



		$result = '<div class="gallery">';

		while($query->have_posts()): $query->the_post();

			$result .= '<div class="product-gallery">

							<div class="gallery-img"><a target="_blank" href="' . esc_url(get_post_meta(get_the_ID(), 'cmc-gallery-url', true)) . '">' . get_the_post_thumbnail(get_the_ID(), 'gallery-thumbnail') . '</a></div>

							<span class="gallery-name"><a target="_blank" href="' .  esc_url(get_post_meta(get_the_ID(), 'cmc-gallery-url', true)) . '">' . get_the_title() . ' - ' . get_post_meta(get_the_ID(), 'cmc-gallery-price', true) . '€</a></span>

							<div class="gallery-excerpt">' . get_the_excerpt() . '</div>

						</div>';

		endwhile; wp_reset_postdata();

		$result .= '</div><div class="clear"></div>';

		return $result;

	}

	add_shortcode('cmc-gallery', 'cmc_gallery');



/* Amazon */

//Data Account

$API_options = get_option('cmc_options');

$accessKeyId = $API_options['theme_api_accessKeyId']['value'];

$secretKey = $API_options['theme_api_secretKey']['value'];

$trackingId = $API_options['theme_api_trackingId']['value'];

$region = "es";

$savetext = "Comprando este producto hoy, te ahorras…";

$CTAtext = "Comprar en Amazon AHORA - ";

$pricetext = "Precio Actual:";

$searchonAmazontext = "Consulta la mejor oferta en Amazon";

$logourl = "https://images-na.ssl-images-amazon.com/images/G/30/associates/mariti/banner/uk_associates_14-07-2015_amazon-logo_de-assoc_3_234x60.jpg";

//Prepare request

function aws_signed_url($params)

{

    $method = "GET";

    $host = "ecs.amazonaws." . $GLOBALS['region'];

    $host = "webservices.amazon." . $GLOBALS['region'];

    $uri = "/onca/xml";

    $params["Service"] = "AWSECommerceService";

    $params["AssociateTag"] = $GLOBALS['trackingId'];

    $params["AWSAccessKeyId"] = $GLOBALS['accessKeyId'];

    $params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");

    $params["Version"] = "2013-08-01";

    ksort($params);

    $canonicalized_query = array();

    foreach ($params as $param => $value) {

        $param = str_replace("%7E", "~", rawurlencode($param));

        $value = str_replace("%7E", "~", rawurlencode($value));

        $canonicalized_query[] = $param . "=" . $value;

    }

    $canonicalized_query = implode("&", $canonicalized_query);

    $string_to_sign = $method . "\n" . $host . "\n" . $uri . "\n" . $canonicalized_query;

    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $GLOBALS['secretKey'], true));

    $signature = str_replace("%7E", "~", rawurlencode($signature));

    $signedUrl = "http://" . $host . $uri . "?" . $canonicalized_query . "&Signature=" . $signature;

    return $signedUrl;

}

//Request products from API

function get_amazon_lowest_price_product($kw)

{

    $params = array(

        "Operation" => "ItemSearch",

        "SearchIndex" => "All",

        "Keywords" => "$kw",

        "ResponseGroup" => "Images,ItemAttributes,Offers",

        "Condition" => "New",

    );

    $url = aws_signed_url($params);

    $response = wp_remote_get(esc_url_raw($url));

    $body = wp_remote_retrieve_body($response);

    $xml = simplexml_load_string($body);

    $item = $xml->Items->Item;

    $title = ( string )$item[0]->ItemAttributes->Title;

    $url = ( string )$item[0]->DetailPageURL;

    $image = ( string )$item[0]->LargeImage->URL;

    $list_price = ( string )$item[0]->ItemAttributes->ListPrice->Amount / 100;

    $price = ( string )$item[0]->Offers->Offer->OfferListing->Price->Amount / 100;

    $you_save = ( string )$item[0]->Offers->Offer->OfferListing->AmountSaved->Amount / 100;

    $price_mp = ( string )$item[0]->Offers->Offer->OfferListing->SalePrice->Amount / 100;

    $valid = ( string )$xml->Items->Request->IsValid;

    $available = ( string )$item[0]->Offers->TotalOffers;

    $error = ( string )$xml->Items->Request->Errors->Error[0]->Message;

    $info = array(

        "code" => $code,

        "price" => $price,

        "list_price" => $list_price,

        "you_save" => $you_save,

        "image" => $image,

        "url" => $url,

        "title" => $title,

        "item" => $item_a,

        "price_mp" => $price_mp,

        "valid" => $valid,

        "error" => $error,

        "available" => $available

    );

    return $info;

}

// Shortcode function

function cmc_product($attrs) {

    $kw = $attrs['kw'];

    $button_class = $attrs['button_class'] ?: 'single_review_bar';

    $link_rel = $attrs['rel'] ?: 'nofollow';

    $link_target = $attrs['target'] ?: '_blank';

    if (false === ($product_info = get_transient($kw))) {

        // It wasn't there, so regenerate the data and save the transient

        $product_info = get_amazon_lowest_price_product($kw);

        set_transient($kw, $product_info, 24 * HOUR_IN_SECONDS);

    }

    // HTML code creation

    // Check valid request

    if ($product_info['valid'] == True) {

        //If product not available, search on Amazon

        if ($product_info['available'] == 0) {

            $HTML = '<a href="http://www.amazon.' . $GLOBALS['region'] . '/s/?tag=' . $GLOBALS['trackingId'] . '&hidden-keywords=' . $kw . '" target="_blank" rel="nofollow">';

            $HTML .= '<center> ' . $GLOBALS['searchonAmazontext'] . ' </strike>&nbsp</i></span><br><br></a>';

            

        }

		//The product is available

        if($product_info['available'] == 1) {

            if ($product_info['listprice'] == null) {

                if ($product_info['price_mp'] == null) {

                    $price = $product_info['price'] . '&#8364';

                } else {

                    $price = $product_info['price_mp'] . '&#8364';

                }

            } else {

                $price = $product_info['price'] . '&#8364';

            }

            $button_text = sprintf('%s %s', $GLOBALS['CTAtext'], $price);

            //NUEVO DISEÑO

			$HTML = '<div class="show-product product">';

				$HTML .= '<div class="show-product-content">

								<a rel="nofollow" href="' . $product_info['url'] . '"><img src="' . $product_info['image'] . '"></a>

								<h2><a rel="nofollow" href="' . $product_info['url'] . '">' . $product_info['title'] . '</a></h2>

								<a rel="nofollow" href="' . $product_info['url'] . '" class="button">' . $button_text . '</a>

							</div>';

			$HTML .= '</div><div class="clear"></div>';

			//NUEVO DISEÑO

        }

    } else {

        //Replicate request if limit reached

        sleep(1);

        $product_info = get_amazon_lowest_price_product($kw);

        // Check valid request

        if ($product_info['valid'] == True) {

            //If product not available, search on Amazon

            if ($product_info['available'] == 0) {

                $HTML = '<a href="http://www.amazon.' . $GLOBALS['region'] . '/s/?tag=' . $GLOBALS['trackingId'] . '&hidden-keywords=' . $kw . '" target="_blank" rel="nofollow">';

                $HTML .= '<center> ' . $GLOBALS['searchonAmazontext'] . ' </strike>&nbsp</i></span><br><br></a>';

                // The product is available

            } else {

                if ($product_info['listprice'] == null) {

                    if ($product_info['price_mp'] == null) {

                        $price = $product_info['price'];

                    } else {

                        $price = $product_info['price_mp'];

                    }

                } else {

                    $price = $product_info['price'];

                }

		            //NUEVO DISEÑO

					$HTML = '<div class="show-product product">';

						$HTML .= '<div class="show-product-content">

										<a rel="nofollow" href="' . $product_info['url'] . '"><img src="' . $product_info['image'] . '"></a>

										<h2><a rel="nofollow" href="' . $product_info['url'] . '">' . $product_info['title'] . '</a></h2>

										<a rel="nofollow" href="' . $product_info['url'] . '" class="button">' . $button_text . '</a>

									</div>';

					$HTML .= '</div><div class="clear"></div>';

					//NUEVO DISEÑO

            }

        }

    }

    if (!is_null($content)) {

    }

    // Return HTML code

    return $HTML;

}

add_shortcode('amazon', 'cmc_product');

//Comprar mi cafetera Request

/*function cmc_amazon_get_data($kw)

{

    $params = array(

        "Operation" => "ItemSearch",

        "SearchIndex" => "All",

        "Keywords" => "$kw",

        "ResponseGroup" => "Images,ItemAttributes,Offers",

        "Condition" => "New",

    );

    $url = aws_signed_url($params);

    $response = wp_remote_get(esc_url_raw($url));

    $body = wp_remote_retrieve_body($response);

    $xml = simplexml_load_string($body);

    $item = $xml->Items->Item;

    $data = array(

        'url' => (string)$item[0]->DetailPageURL,

        'price' => (string)$item[0]->Offers->Offer->OfferListing->Price->Amount / 100,

        'discount' => (string)$item[0]->Offers->Offer->OfferListing->AmountSaved->Amount / 100,

        'price_3' => (string)$item[0]->Offers->Offer->OfferListing->SalePrice->Amount / 100,

        'available' => (string)$item[0]->Offers->TotalOffers

    );

    return $data;

}*/

/* Amazon */


	/* Infinite Scroll */

	function cmc_get_next_products() {

		if(!empty($_POST['taxonomy']) && !empty($_POST['term'])) {

			$args = array(

				'posts_per_page' => 12,

				'offset' => $_POST['offset'],

				'post_type' => $_POST['postType'],

				'orderby' => 'date',

				'tax_query' => array(

					array(

						'taxonomy' => $_POST['taxonomy'],

						'field' => 'slug',

						'terms' => $_POST['term']

					)

				)

			);

		}

		else {

			$args = array(

				'posts_per_page' => 12,

				'offset' => $_POST['offset'],

				'post_type' => $_POST['postType'],

				'orderby' => 'date'

			);

		}

		$query = new WP_Query($args);



		if(!$query->have_posts()) {

			echo 2;

			die;

		}

		else {

			$result = '';

			while($query->have_posts()): $query->the_post();

				$data = cmc_get_prodcut_data(get_the_ID(), get_post_type());


				if($data['price'] != '') {
					$price = '<div class="read-more price"><span>' . $data['price'] . ' €</span></div>';
				} else {
					$price = '<div class="read-more"><a href="' . get_the_permalink() . '">' . __('Acceder >>') . '</a></div>';
				}
				$result .= '<div class="article-2">
								<div class="entry-header-2">
									<a class="post-thumbnail-2" href="' . get_the_permalink() . '"><img src="' . $data['image-medium'] . '"></a>
									<a class="post-title-2" href="' . get_the_permalink() . '"><h2>' . get_the_title() . '</h2></a>
								</div>
								<div class="entry-content-2">' . mb_substr(wp_strip_all_tags(get_the_content()), 0, 135) . '...</div>
								' . $price . '
							</div>';

			endwhile; wp_reset_postdata();

			echo $result;
			die;
		}
	}

	add_action('wp_ajax_cmc_get_next_products', 'cmc_get_next_products');

	add_action('wp_ajax_nopriv_cmc_get_next_products', 'cmc_get_next_products');



	/* Facebook Script */

	function get_facebook_script() {

		return '<div id="fb-root"></div>

				<script>(function(d, s, id) {

				  var js, fjs = d.getElementsByTagName(s)[0];

				  if (d.getElementById(id)) return;

				  js = d.createElement(s); js.id = id;

				  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.10&appId=648600791910489";

				  fjs.parentNode.insertBefore(js, fjs);

				}(document, "script", "facebook-jssdk"));</script>';

	}



	/* Rich snippets */

	function get_rich_snippets() {

		if(get_post_type() == 'main_product' || get_post_type() == 'related_product_1' || get_post_type() == 'related_product_2') {

			$data = cmc_get_prodcut_data(get_the_ID(), get_post_type());

			$score = $data['score'];

			$product = get_the_title();

			$ratingoutput = '<script type="application/ld+json">{"@context": "http://schema.org","@type": "Product","name": "' . $product . '","aggregateRating": {"@type": "AggregateRating","ratingValue": "' . $score . '"}}</script>';

			return $ratingoutput;

		}

		else

			return '';

	}



	function cmc_the_styles() {

		$options = get_option('cmc_options');



		$styles = '<style type="text/css">';

		$styles .= '.button{background:' . $options['theme_background_button_1']['value'] . ';color:' . $options['theme_color_button_1']['value'] . ';}.button:hover{background:' . $options['theme_background_hover_button_1']['value'] . ';}.button-2{background:' . $options['theme_background_button_2']['value'] . ';color:' . $options['theme_color_button_2']['value'] . ';}.button-2:hover{background:' . $options['theme_background_hover_button_2']['value'] . ';}.price{color:' . $options['theme_color_price']['value'] . ';}a{color:' . $options['theme_color_link']['value'] . ';}strong{color:' . $options['theme_color_strong']['value'] . ';}h1{font-size:' . $options['theme_size_h1']['value'] . 'rem;}h2{font-size:' . $options['theme_size_h2']['value'] . 'rem;}h3{font-size:' . $options['theme_size_h3']['value'] . 'rem;}p,ul{font-size:' . $options['theme_size_text']['value'] . 'px;line-height:' . $options['theme_line_height_text']['value'] . '%;}.product-button{background:' . $options['theme_background_button_product']['value'] . ';color:' . $options['theme_color_button_product']['value'] . ';}.product-button:hover{background:' . $options['theme_background_hover_button_product']['value'] . ';}.product-header h1{font-size:' . $options['theme_size_product_title']['value'] . 'rem;}.list-posts .entry-content, .search .entry-content, .search-content{font-size:' . $options['theme_size_extract_text']['value'] . 'rem;line-height:' . $options['theme_size_extract_lineheight']['value'] . ';}.price-old{color:' . $options['theme_color_price_old']['value'] . ';}';

		$styles .= '</style>';



		return $styles;

	}



	//1. Add theme settings page to menu

	function cmc_add_settings_page() {

		$tt_page = add_menu_page('Personalización de la plantilla', 'Comprar mi cafetera', 'manage_options', 'cmc_settings_page', 'cmc_settings', 'dashicons-admin-generic', 59);

		add_action('admin_print_styles-'.$tt_page,'cmc_settings_scripts');

	}

	add_action('admin_menu', 'cmc_add_settings_page');



	//Styles y scripts que se cargarán únicamente en la página de la plantilla

	function cmc_settings_scripts() {

		wp_enqueue_style('admin', get_template_directory_uri() . '/css/admin.css');

	}



	//2. Create options when install theme

	function cmc_create_settings_options() {

		//if(!get_option('cmc_options')) {

			$options = array();

			$shortname = 'theme';



			//General Settings

			$options[$shortname.'_general_settings'] = array('type' => 'section',

							'id' => $shortname.'_general_settings',

							'name' => __('Ajustes Generales'),

							'desc' => __('Configuración de las opciones generales de la plantilla'));



			$options[$shortname.'_logo'] = array('type' => 'hidden-image',

							'id' => $shortname.'_logo',

							'name' => __('Logo'),

							'desc' => __('Logo de la página web'),

							'value' => __('/wp-content/themes/comprarmicafetera/img/logo.png'));



			$options[$shortname.'_favicon'] = array('type' => 'hidden-image',

							'id' => $shortname.'_favicon',

							'name' => __('Favicon'),

							'desc' => __('Favicon de la página web'),

							'value' => __('/wp-content/themes/comprarmicafetera/img/favicon.png'));



			$options[$shortname.'_subtitle'] = array('type' => 'text',

							'id' => $shortname.'_subtitle',

							'name' => __('Subtítulo'),

							'desc' => __('Texto del subtítulo que hay debajo del logo'),

							'value' => __('Análisis y opiniones de cafeteras, molinillos de café y espumadores de leche'));



			$options[$shortname.'_404_text'] = array('type' => 'wp-editor',

							'id' => $shortname.'_404_text',

							'name' => __('Texto página 404'),

							'desc' => __('Texto que aparecerá en la página de error 404'),

							'value' => __(''));

			$options[$shortname.'_search_text'] = array('type' => 'wp-editor',

							'id' => $shortname.'_search_text',

							'name' => __('Texto página búsqueda'),

							'desc' => __('Texto que aparecerá cuando no hay resultados al hacer una búsqueda'),

							'value' => __(''));

			//Elementos

			$options[$shortname.'_elements_settings'] = array('type' => 'section',

							'id' => $shortname.'_elements_settings',

							'name' => __('Botones y otros elementos'),

							'desc' => __('Configuración de los botones y elementos'));



			$options[$shortname.'_background_button_1'] = array('type' => 'text',

							'id' => $shortname.'_background_button_1',

							'name' => __('Fondo botón 1'),

							'desc' => __('Color de fondo del botón principal'),

							'value' => __('#ebc462'));



			$options[$shortname.'_background_hover_button_1'] = array('type' => 'text',

							'id' => $shortname.'_background_hover_button_1',

							'name' => __('Fondo hover botón 1'),

							'desc' => __('Color de fondo del botón principal al pasar el ratón'),

							'value' => __('#efb522'));



			$options[$shortname.'_color_button_1'] = array('type' => 'text',

							'id' => $shortname.'_color_button_1',

							'name' => __('Color texto botón 1'),

							'desc' => __('Color del texto del botón principal'),

							'value' => __('#326dab'));



			$options[$shortname.'_background_button_2'] = array('type' => 'text',

							'id' => $shortname.'_background_button_2',

							'name' => __('Fondo botón 2'),

							'desc' => __('Color de fondo del botón de análisis'),

							'value' => __('#326dab'));



			$options[$shortname.'_background_hover_button_2'] = array('type' => 'text',

							'id' => $shortname.'_background_hover_button_2',

							'name' => __('Fondo hover botón 2'),

							'desc' => __('Color de fondo del botón de análisis al pasar el ratón'),

							'value' => __('#144b86'));



			$options[$shortname.'_color_button_2'] = array('type' => 'text',

							'id' => $shortname.'_color_button_2',

							'name' => __('Color texto botón 2'),

							'desc' => __('Color del texto del botón de análisis'),

							'value' => __('#ffffff'));



			$options[$shortname.'_color_price'] = array('type' => 'text',

							'id' => $shortname.'_color_price',

							'name' => __('Color precio'),

							'desc' => __('Color del precio en los shortcodes'),

							'value' => __('#339900'));



			$options[$shortname.'_color_price_old'] = array('type' => 'text',

							'id' => $shortname.'_color_price_old',

							'name' => __('Color precio tachado'),

							'desc' => __('Color del precio tachado'),

							'value' => __('#b4b4b4'));


			$options[$shortname.'_color_link'] = array('type' => 'text',

							'id' => $shortname.'_color_link',

							'name' => __('Color enlaces'),

							'desc' => __('Color de los enlaces en los textos'),

							'value' => __('#326dab'));



			$options[$shortname.'_color_strong'] = array('type' => 'text',

							'id' => $shortname.'_color_strong',

							'name' => __('Color negritas'),

							'desc' => __('Color de los textos dentro de la etiqueta strong'),

							'value' => __('#000000'));



			$options[$shortname.'_size_h1'] = array('type' => 'text',

							'id' => $shortname.'_size_h1',

							'name' => __('Tamaño H1 (rem)'),

							'desc' => __('Tamaño de fuente de la etiqueta H1'),

							'value' => __('2.5'));



			$options[$shortname.'_size_h2'] = array('type' => 'text',

							'id' => $shortname.'_size_h2',

							'name' => __('Tamaño H2 (rem)'),

							'desc' => __('Tamaño de fuente de la etiqueta H2'),

							'value' => __('1.5'));



			$options[$shortname.'_size_h3'] = array('type' => 'text',

							'id' => $shortname.'_size_h3',

							'name' => __('Tamaño H3 (rem)'),

							'desc' => __('Tamaño de fuente de la etiqueta H3'),

							'value' => __('1.2'));



			$options[$shortname.'_size_text'] = array('type' => 'text',

							'id' => $shortname.'_size_text',

							'name' => __('Tamaño letra contenido (px)'),

							'desc' => __('Tamaño letra del texto de los productos y artículos'),

							'value' => __('18'));



			$options[$shortname.'_line_height_text'] = array('type' => 'text',

							'id' => $shortname.'_line_height_text',

							'name' => __('Line height Texto (%)'),

							'desc' => __('Line height del contenido'),

							'value' => __('155'));



			//Ficha producto

			$options[$shortname.'_products_settings'] = array('type' => 'section',

							'id' => $shortname.'_products_settings',

							'name' => __('Ficha del producto'),

							'desc' => __('Configuración de los elementos en la ficha del producto'));



			$options[$shortname.'_background_button_product'] = array('type' => 'text',

							'id' => $shortname.'_background_button_product',

							'name' => __('Fondo botón producto'),

							'desc' => __('Color de fondo del botón, dentro de la ficha del producto'),

							'value' => __('#f0c350'));



			$options[$shortname.'_background_hover_button_product'] = array('type' => 'text',

							'id' => $shortname.'_background_hover_button_product',

							'name' => __('Fondo hover botón producto'),

							'desc' => __('Color de fondo del botón del producto al pasar el ratón'),

							'value' => __('#efb522'));



			$options[$shortname.'_color_button_product'] = array('type' => 'text',

							'id' => $shortname.'_color_button_product',

							'name' => __('Color texto botón producto'),

							'desc' => __('Color del texto del botón dentro del producto'),

							'value' => __('#ffffff'));



			$options[$shortname.'_size_product_title'] = array('type' => 'text',

							'id' => $shortname.'_size_product_title',

							'name' => __('Tamaño título producto (rem)'),

							'desc' => __('Tamaño de fuente del título del producto'),

							'value' => __('2.3'));

			$options[$shortname.'_size_extract_text'] = array('type' => 'text',
							'id' => $shortname.'_size_extract_text',
							'name' => __('Tamaño del extracto (rem)'),
							'desc' => __('Tamaño de fuente del extracto'),
							'value' => __('1'));

			$options[$shortname.'_size_extract_lineheight'] = array('type' => 'text',
							'id' => $shortname.'_size_extract_lineheight',
							'name' => __('Tamaño del interlineado (rem)'),
							'desc' => __('Tamaño de interlineado del extracto'),
							'value' => __('1.3'));
			update_option('cmc_options', $options);

			update_option('cmc_shortname', $shortname);
		//}

	}

	add_action('after_switch_theme','cmc_create_settings_options'); //Se ejecuta después de instalar la plantilla


	//3. Admin settings page

	function cmc_settings() {

		cmc_update_options();

		$options = get_option('cmc_options');

		/*if(!array_key_exists('theme_legal_comments', $options)) {

					$options['theme_legal_comments'] = array('type' => 'wp-editor',

									'id' => 'theme_legal_comments',

									'name' => __('Texto legal comentarios'),

									'desc' => __('Texto legal que se mostrará en los comentarios'),

									'value' => __(''));

					update_option('cmc_options', $options);
		}*/

		?>

			<div class="wrap">

				<h1><?php _e('Configuración de la plantilla') ?></h1>

				<div>

					<?php echo cmc_format_options($options); ?>

				</div>

			</div>

		<?php

	}



	//4. HTML format options

	function cmc_format_options($options) {

		$html_options = '<form method="post" enctype="multipart/form-data">';

		$opened_section = false;



		foreach($options as $option) {

			switch ($option['type']) {

				case 'section':

					if($opened_section) $html_options .= '</div>';

					$html_options .= '<div id="' . $option['id'] . '" class="cmc-section-tab"><input class="cmc-button" type="submit" name="' . $option['id'] . '" value="' . __('Guardar') . '"><h1>' . $option['name'] . '</h1>';

					$opened_section = true;

					break;



				case 'text':

					$html_options .= '<div class="cmc-input"><label>' . $option['name'] . ':<small>' . $option['desc'] . '</small></label> <input type="text" id="' . $option['id'] . '" name="' . $option['id'] . '" value="' . esc_attr($option['value']) . '" placeholder="' . $option['desc'] . '"></div>';

					break;



				case 'wp-editor':

					$html_options .= '<div class="cmc-wpeditor"><label>' . $option['name'] . ':<small>' . $option['desc'] . '</small></label> ';

					ob_start();

					wp_editor($option['value'], $option['id'], array('textarea_name' => $option['id']));

					$html_options .= ob_get_clean() . '</div>';

					break;



				case 'hidden-image':

					$html_options .= '<div class="cmc-input"><label>' . $option['name'] . ':<small>' . $option['desc'] . '</small></label> <input type="file" id="' . $option['id'] . '" name="' . $option['id'] . '" value="' . $option['value'] . '">';

					if(!empty($option['value'])) $html_options .= '<img src="' . esc_attr($option['value']) . '"></div>';

					break;

			}

		}

		if($opened_section) $html_options .= '</div>';



		$html_options .= '</form>';

		return $html_options;

	}



	//5. Update options

	function cmc_update_options() {

		$options = get_option('cmc_options');



		if(!function_exists('wp_handle_upload')) {

			require_once(ABSPATH . 'wp-admin/includes/file.php');

		}



		foreach($options as $option) {

			if(array_key_exists($option['id'], $_POST) || array_key_exists($option['id'], $_FILES)) {

				switch ($option['type']) {

					case 'text':

					case 'wp-editor':

						$option['value'] = stripslashes($_POST[$option['id']]);

						break;



					case 'hidden-image':

						if(!empty($_FILES[$option['id']])) {

							$uploadedfile = $_FILES[$option['id']];

							$upload_overrides = array('test_form' => false);

							$movefile = wp_handle_upload($uploadedfile, $upload_overrides);



							if($movefile && !isset($movefile['error'])) {

								$option['value'] = $movefile['url'];

							}

						}

						else {

							$option['value'] = $_POST[$option['id']];

						}

						break;

				}

				$options[$option['id']] = $option;

			}

		}



		update_option('cmc_options', $options);

	}

if(!function_exists('cmc_content_editor_on_posts_page')) {
    function cmc_content_editor_on_posts_page($post) {
        if(isset($post) && $post->ID != get_option('page_for_posts')) {
            return;
        }

        remove_action('edit_form_after_title', '_wp_posts_page_notice');
        add_post_type_support('page', 'editor');
    }
    add_action('edit_form_after_title', 'cmc_content_editor_on_posts_page', 0);
}

function cmc_latest_posts($atts, $content = '') {
	$args = array(
		'numberposts' => 9,
		'offset' => 0,
		'category' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'include' => '',
		'exclude' => '',
		'meta_key' => '',
		'meta_value' =>'',
		'post_type' => 'post',
		'post_status' => 'publish',
		'suppress_filters' => true
	);
	$latest_posts = wp_get_recent_posts($args);
	$latest_posts_html = '';
	foreach($latest_posts as $current) {
		$current_post_thumbnail = get_the_post_thumbnail($current['ID'], 'product-medium');
		$latest_posts_html .= '<div class="article-2">
			<header class="entry-header-2">
				<a class="post-thumbnail-2" href="' . get_permalink($current['ID']) . '">' . $current_post_thumbnail . '</a>
				<a class="post-title-2" href="' . get_permalink($current['ID']) . '"><h2>' . $current['post_title'] . '</h2></a>
			</header>
			<div class="entry-content-2">' . mb_substr(wp_strip_all_tags($current['post_content']), 0, 135) . '...</div>
			<div class="read-more"><a href="' . get_permalink($current['ID']) . '">Leer más >></a></div>
		</div>';
	}
	wp_reset_query();

	$latest_posts_html = $latest_posts_html . '<div class="clear"></div>';
	return $latest_posts_html;
}
add_shortcode('cmc-latest-posts', 'cmc_latest_posts');

add_filter('xmlrpc_methods', function($methods) {
	unset( $methods['pingback.ping'] );
	return $methods;
});

?>