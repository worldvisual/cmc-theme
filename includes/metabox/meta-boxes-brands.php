<?php

// sets up custom product specs on main product page
function uat_brands_meta_create() {
    add_meta_box(
        'uat_brand_image', 
        'Imagen de la marca (Optional)', 
        'uat_brand_image_function', 
        'brands', 
        'normal', 
        'high'
    );
    add_meta_box(
        'uat_brand_website', 
        'Página oficial', 
        'uat_brand_website_function', 
        'brands', 
        'normal', 
        'high'
    );
}
add_action('add_meta_boxes', 'uat_brands_meta_create');


function uat_brand_image_function($post) {

	// Add an nonce field so we can check for it later when validating
  wp_nonce_field( 'brand_inner_custom_box', 'brand_inner_custom_box_nonce' );
	// retrieve the metadata values if they exist
  $brand_img = get_post_meta( $post->ID, '_brand_img', true );
  $image= esc_attr($brand_img);

  if($image==''):
    $image_url_string = get_site_url().'/wp-content/themes/ultimateazon/images/no-product-image.jpg';
  else:
    $size = 'medium';
    $image_src=wp_get_attachment_image_src( $image, $size );
    $image_url_string = $image_src[0];
  endif;

  if ( $image_url_string == '/wp-content/themes/ultimateazon/images/no-product-image.jpg') {$hideshow='style="display: none"';} else {$hideshow='style="display: inline-block"';}
?>

    <p class="admin-tip"><?php _e('Tamaño recomendado: 300x300px' ); ?></p>
    <br />
    <!-- change type back to text to see img path -->
    <?php /* CUSTOM */
      wp_enqueue_script('jquery');
      wp_enqueue_media();
      /* END CUSTOM */
    ?>
    <input type="hidden" id="brand_img" name="brand_img" value="<?php echo esc_attr($brand_img); ?>" />
    <input id="upload_brand_image" type="button" class="button" value="<?php _e( 'Cargar imagen', 'uat' ); ?>" />

    <!-- ENABLED <input id="delete_brand_image" name="delete_brand_image" type="submit" class="button" <?php echo $hideshow; ?> value="<?php _e( 'Delete Image', 'uat' ); ?>" /> END ENABLED-->

    <div id="upload_brand_preview">
    <?php /* CUSTOM */
      if($brand_img != '') echo '<br><img src="' . esc_attr($image_url_string) . '" width="250">';
      else echo '<br><img src="/wp-content/themes/comprarmicafetera/img/no-product-image.jpg" width="250">';
      /* END CUSTOM */
    ?>

    </div>
    <?php /* CUSTOM */ ?>
    <script type="text/javascript">
    jQuery(document).ready(function($){
      $('#upload_brand_image').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
          title: 'Cargar imagen',
          multiple: false
        }).open()
        .on('select', function(e){
          var uploaded_image = image.state().get('selection').first();
          var image_id = uploaded_image.toJSON().id;
          var image_url = uploaded_image.toJSON().url;
          $('#brand_img').val(image_id);
          $('#upload_brand_preview').html('<br/><img src="' + image_url + '" width="250">');
        });
      });
    });
    </script>
    <?php /* END CUSTOM */ ?>
<?php
}


function uat_brand_website_function($post) {
	// Add an nonce field so we can check for it later when validating
  wp_nonce_field( 'brand_website_custom_box', 'brand_website_custom_box_nonce' );

  $brand_website = get_post_meta( $post->ID, '_brand_website', true );
  ?>

  <div class="amatheme-metabox">
    <label>Página de la marca</label>
    <input class="full-width_input" type="text" name="brand_website" value="<?php echo esc_attr($brand_website); ?>" />
  </div>

<?php
}


// save custom product specs fields meta data
function uat_brand_save_image($post_id) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['brand_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['brand_inner_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'brand_inner_custom_box' ) )
    return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;

  // Check the user's permissions.
  if ( 'brands' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
    return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // If old entries exist, retrieve them
  $old_image = get_post_meta( $post_id, '_brand_img', true );

  // Sanitize user input.
  $image = sanitize_text_field( $_POST['brand_img'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_brand_img', $image, $old_image );
}
add_action( 'save_post', 'uat_brand_save_image' );


function uat_brand_website_save_function($post_id) {

  // Check if our nonce is set.
  if ( ! isset( $_POST['brand_website_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['brand_website_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'brand_website_custom_box' ) )
    return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;

  // Check the user's permissions.
  if ( 'brands' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }
 
  /* OK, its safe for us to save the data now. */
  $old_brand_website = get_post_meta( $post->ID, '_brand_website', true );
  $user_brand_website = sanitize_text_field( $_POST['brand_website'] );
  update_post_meta( $post_id, '_brand_website', $user_brand_website, $old_brand_website );
}
add_action( 'save_post', 'uat_brand_website_save_function' );
