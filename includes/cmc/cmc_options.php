<?php

/*
|--------------------------------------------------------------------------
| 1. Add theme settings page to menu
|--------------------------------------------------------------------------
*/
function cmc_add_settings_page(){
  $tt_page = add_menu_page('Personalización de la plantilla', 'Comprar mi cafetera', 'manage_options', 'cmc_settings_page', 'cmc_settings', 'dashicons-admin-generic', 59);
  add_action('admin_print_styles-' . $tt_page, 'cmc_settings_scripts');
}
add_action('admin_menu', 'cmc_add_settings_page');


//Styles y scripts que se cargarán únicamente en la página de la plantilla
function cmc_settings_scripts(){
  wp_enqueue_style('admin', get_template_directory_uri() . '/css/admin.min.css');
}


/*
|--------------------------------------------------------------------------
| 2. Create options when install theme
|--------------------------------------------------------------------------
*/
function cmc_create_settings_options(){

  $options = array();
  $shortname = 'theme';

  // General Settings
  $options[$shortname . '_general_settings'] = array(
    'type' => 'section',
    'id' => $shortname . '_general_settings',
    'name' => __('Ajustes Generales'),
    'desc' => __('Configuración de las opciones generales de la plantilla')
  );

  $options[$shortname . '_logo'] = array(
    'type' => 'hidden-image',
    'id' => $shortname . '_logo',
    'name' => __('Logo'),
    'desc' => __('Logo de la página web'),
    'value' => __('/wp-content/themes/comprarmicafetera/assets/images/logo.png')
  );

  $options[$shortname . '_favicon'] = array(
    'type' => 'hidden-image',
    'id' => $shortname . '_favicon',
    'name' => __('Favicon'),
    'desc' => __('Favicon de la página web'),
    'value' => __('/wp-content/themes/comprarmicafetera/assets/images/favicon.png')
  );

  $options[$shortname . '_subtitle'] = array(
    'type' => 'text',
    'id' => $shortname . '_subtitle',
    'name' => __('Subtítulo'),
    'desc' => __('Texto del subtítulo que hay debajo del logo'),
    'value' => __('Análisis y opiniones de cafeteras, molinillos de café y espumadores de leche')
  );

  $options[$shortname . '_404_text'] = array(
    'type' => 'wp-editor',
    'id' => $shortname . '_404_text',
    'name' => __('Texto página 404'),
    'desc' => __('Texto que aparecerá en la página de error 404'),
    'value' => __('')
  );

  $options[$shortname . '_search_text'] = array(
    'type' => 'wp-editor',
    'id' => $shortname . '_search_text',
    'name' => __('Texto página búsqueda'),
    'desc' => __('Texto que aparecerá cuando no hay resultados al hacer una búsqueda'),
    'value' => __('')
  );

  // Elements
  $options[$shortname . '_elements_settings'] = array(
    'type' => 'section',
    'id' => $shortname . '_elements_settings',
    'name' => __('Botones y otros elementos'),
    'desc' => __('Configuración de los botones y elementos')
  );

  $options[$shortname . '_background_button_1'] = array(
    'type' => 'text',
    'id' => $shortname . '_background_button_1',
    'name' => __('Fondo botón 1'),
    'desc' => __('Color de fondo del botón principal'),
    'value' => __('#ebc462')
  );

  $options[$shortname . '_background_hover_button_1'] = array(
    'type' => 'text',
    'id' => $shortname . '_background_hover_button_1',
    'name' => __('Fondo hover botón 1'),
    'desc' => __('Color de fondo del botón principal al pasar el ratón'),
    'value' => __('#efb522')
  );

  $options[$shortname . '_color_button_1'] = array(
    'type' => 'text',
    'id' => $shortname . '_color_button_1',
    'name' => __('Color texto botón 1'),
    'desc' => __('Color del texto del botón principal'),
    'value' => __('#326dab')
  );

  $options[$shortname . '_background_button_2'] = array(
    'type' => 'text',
    'id' => $shortname . '_background_button_2',
    'name' => __('Fondo botón 2'),
    'desc' => __('Color de fondo del botón de análisis'),
    'value' => __('#326dab')
  );

  $options[$shortname . '_background_hover_button_2'] = array(
    'type' => 'text',
    'id' => $shortname . '_background_hover_button_2',
    'name' => __('Fondo hover botón 2'),
    'desc' => __('Color de fondo del botón de análisis al pasar el ratón'),
    'value' => __('#144b86')
  );

  $options[$shortname . '_color_button_2'] = array(
    'type' => 'text',
    'id' => $shortname . '_color_button_2',
    'name' => __('Color texto botón 2'),
    'desc' => __('Color del texto del botón de análisis'),
    'value' => __('#ffffff')
  );

  $options[$shortname . '_color_price'] = array(
    'type' => 'text',
    'id' => $shortname . '_color_price',
    'name' => __('Color precio'),
    'desc' => __('Color del precio en los shortcodes'),
    'value' => __('#339900')
  );

  $options[$shortname . '_color_price_old'] = array(
    'type' => 'text',
    'id' => $shortname . '_color_price_old',
    'name' => __('Color precio tachado'),
    'desc' => __('Color del precio tachado'),
    'value' => __('#b4b4b4')
  );

  $options[$shortname . '_color_link'] = array(
    'type' => 'text',
    'id' => $shortname . '_color_link',
    'name' => __('Color enlaces'),
    'desc' => __('Color de los enlaces en los textos'),
    'value' => __('#326dab')
  );

  $options[$shortname . '_color_strong'] = array(
    'type' => 'text',
    'id' => $shortname . '_color_strong',
    'name' => __('Color negritas'),
    'desc' => __('Color de los textos dentro de la etiqueta strong'),
    'value' => __('#000000')
  );

  $options[$shortname . '_size_h1'] = array(
    'type' => 'text',
    'id' => $shortname . '_size_h1',
    'name' => __('Tamaño H1 (rem)'),
    'desc' => __('Tamaño de fuente de la etiqueta H1'),
    'value' => __('2.5')
  );

  $options[$shortname . '_size_h2'] = array(
    'type' => 'text',
    'id' => $shortname . '_size_h2',
    'name' => __('Tamaño H2 (rem)'),
    'desc' => __('Tamaño de fuente de la etiqueta H2'),
    'value' => __('1.5')
  );

  $options[$shortname . '_size_h3'] = array(
    'type' => 'text',
    'id' => $shortname . '_size_h3',
    'name' => __('Tamaño H3 (rem)'),
    'desc' => __('Tamaño de fuente de la etiqueta H3'),
    'value' => __('1.2')
  );

  $options[$shortname . '_size_text'] = array(
    'type' => 'text',
    'id' => $shortname . '_size_text',
    'name' => __('Tamaño letra contenido (px)'),
    'desc' => __('Tamaño letra del texto de los productos y artículos'),
    'value' => __('18')
  );

  $options[$shortname . '_line_height_text'] = array(
    'type' => 'text',
    'id' => $shortname . '_line_height_text',
    'name' => __('Line height Texto (%)'),
    'desc' => __('Line height del contenido'),
    'value' => __('155')
  );

  // product file
  $options[$shortname . '_products_settings'] = array(
    'type' => 'section',
    'id' => $shortname . '_products_settings',
    'name' => __('Ficha del producto'),
    'desc' => __('Configuración de los elementos en la ficha del producto')
  );

  $options[$shortname . '_background_button_product'] = array(
    'type' => 'text',
    'id' => $shortname . '_background_button_product',
    'name' => __('Fondo botón producto'),
    'desc' => __('Color de fondo del botón, dentro de la ficha del producto'),
    'value' => __('#f0c350')
  );

  $options[$shortname . '_background_hover_button_product'] = array(
    'type' => 'text',
    'id' => $shortname . '_background_hover_button_product',
    'name' => __('Fondo hover botón producto'),
    'desc' => __('Color de fondo del botón del producto al pasar el ratón'),
    'value' => __('#efb522')
  );

  $options[$shortname . '_color_button_product'] = array(
    'type' => 'text',
    'id' => $shortname . '_color_button_product',
    'name' => __('Color texto botón producto'),
    'desc' => __('Color del texto del botón dentro del producto'),
    'value' => __('#ffffff')
  );

  $options[$shortname . '_size_product_title'] = array(
    'type' => 'text',
    'id' => $shortname . '_size_product_title',
    'name' => __('Tamaño título producto (rem)'),
    'desc' => __('Tamaño de fuente del título del producto'),
    'value' => __('2.3')
  );

  $options[$shortname . '_size_extract_text'] = array(
    'type' => 'text',
    'id' => $shortname . '_size_extract_text',
    'name' => __('Tamaño del extracto (rem)'),
    'desc' => __('Tamaño de fuente del extracto'),
    'value' => __('1')
  );

  $options[$shortname . '_size_extract_lineheight'] = array(
    'type' => 'text',
    'id' => $shortname . '_size_extract_lineheight',
    'name' => __('Tamaño del interlineado (rem)'),
    'desc' => __('Tamaño de interlineado del extracto'),
    'value' => __('1.3')
  );

  // Config - Amazon
  $options[$shortname . '_configs_amazon'] = array(
    'type' => 'section',
    'id' => $shortname . '_configs_amazon',
    'name' => __('Configuraciones Amazon'),
    'desc' => __('Configuración de información de Amazon para la plantilla')
  );

  $options[$shortname . '_api_accessKeyId'] = array(
    'type' => 'text',
    'id' => $shortname . '_api_accessKeyId',
    'name' => __('API Access Key ID'),
    'value' => $options[$shortname . '_api_accessKeyId']['value']
  );

  $options[$shortname . '_api_secretKey'] = array(
    'type' => 'text',
    'id' => $shortname . '_api_secretKey',
    'name' => __('API Secret Key'),
    'value' => $options[$shortname . '_api_secretKey']['value']
  );

  $options[$shortname . '_api_trackingId'] = array(
    'type' => 'text',
    'id' => $shortname . '_api_trackingId',
    'name' => __('API Tracking ID'),
    'value' => $options[$shortname . '_api_trackingId']['value']
  );

  // Social network
  $options[$shortname . '_social_network'] = array(
    'type' => 'section',
    'id' => $shortname . '_social_network',
    'name' => __('Redes Sociales'),
    'desc' => __('Configuración de los elementos de redes sociales en el menú de cabecera')
  );

  $options[$shortname . '_social_network_facebook'] = array(
    'type' => 'text',
    'id' => $shortname . '_social_network_facebook',
    'name' => __('Facebook'),
    'desc' => __('Configuración del enlace de la página de Facebook'),
    'value' => __('https://facebook.com/')
  );

  $options[$shortname . '_social_network_twitter'] = array(
    'type' => 'text',
    'id' => $shortname . '_social_network_twitter',
    'name' => __('Twitter'),
    'desc' => __('Configuración del enlace de la página de Twitter'),
    'value' => __('https://twitter.com/')
  );

  $options[$shortname . '_social_network_instagram'] = array(
    'type' => 'text',
    'id' => $shortname . '_social_network_instagram',
    'name' => __('Instagram'),
    'desc' => __('Configuración del enlace de la página de Instagram'),
    'value' => __('https://instagram.com/')
  );

  update_option('cmc_options', $options);
  update_option('cmc_shortname', $shortname);

}
add_action('after_switch_theme', 'cmc_create_settings_options'); // execute after instal the screen


function cmc_setup(){
	register_nav_menus(
		array(
			'header_menu' => __('Menú cabecera'),
			'menu_404_1' => __('Primer menú 404'),
			'menu_404_2' => __('Segundo menú 404'),
			'menu_404_3' => __('Tercer menú 404'),
			'footer_menu' => __('Menú pie de página')
		)
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
	add_image_size('thumb-for-post-list', 400);
}
add_action('after_setup_theme', 'cmc_setup');


/*
|--------------------------------------------------------------------------
| 3. Admin settings page
|--------------------------------------------------------------------------
*/
function cmc_settings(){

  cmc_update_options();
  $options = get_option('cmc_options');
?>

  <div class="wrap">
    <h1><?php _e('Configuración de la plantilla') ?></h1>
    <div>
      <?php echo cmc_format_options($options); ?>
    </div>
  </div>
<?php
}


/*
|--------------------------------------------------------------------------
| 4. HTML format options
|--------------------------------------------------------------------------
*/
function cmc_format_options($options){

  $html_options = '<form method="post" enctype="multipart/form-data">';
  $opened_section = false;

  foreach ($options as $option) {
    switch ($option['type']) {
      case 'section':
        if ($opened_section) $html_options .= '</div>';
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
        if (!empty($option['value'])) $html_options .= '<img src="' . esc_attr($option['value']) . '"></div>';
        break;
    }
  }

  if ($opened_section) $html_options .= '</div>';

  $html_options .= '</form>';
  return $html_options;
}


/*
|--------------------------------------------------------------------------
| 5. Update options
|--------------------------------------------------------------------------
*/
function cmc_update_options(){

  $options = get_option('cmc_options');

  if (!function_exists('wp_handle_upload')) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
  }

  foreach ($options as $option) {
    if (array_key_exists($option['id'], $_POST) || array_key_exists($option['id'], $_FILES)) {
      switch ($option['type']) {
        case 'text':
        case 'wp-editor':
          $option['value'] = stripslashes($_POST[$option['id']]);
          break;

        case 'hidden-image':
          if (!empty($_FILES[$option['id']])) {
            $uploadedfile = $_FILES[$option['id']];
            $upload_overrides = array('test_form' => false);
            $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
         
            if ($movefile && !isset($movefile['error'])) {
              $option['value'] = $movefile['url'];
            }
          } else {
            $option['value'] = $_POST[$option['id']];
          }

          break;
      }
      $options[$option['id']] = $option;
    }
  }

  update_option('cmc_options', $options);
}

if (!function_exists('cmc_content_editor_on_posts_page')) {
  function cmc_content_editor_on_posts_page($post)
  {
    if (isset($post) && $post->ID != get_option('page_for_posts')) {
      return;
    }

    remove_action('edit_form_after_title', '_wp_posts_page_notice');
    add_post_type_support('page', 'editor');
  }
  add_action('edit_form_after_title', 'cmc_content_editor_on_posts_page', 0);
}
