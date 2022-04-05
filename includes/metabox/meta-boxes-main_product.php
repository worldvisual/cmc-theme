<?php

// sets up custom product specs on main product page
function uat_main_product_create() {

  add_meta_box(
    'uat_product_specs', 
    'Información del producto', 
    'uat_main_product_specs_function', 
    'main_product', 
    'normal', 
    'high'
  );
  add_meta_box(
    'uat_product-image', 
    'Imagen del producto', 
    'uat_main_product_image_function', 
    'main_product', 
    'normal', 
    'high'
  );
}
add_action('add_meta_boxes', 'uat_main_product_create');


// custom product specs fields
function uat_affiliate_link_bars_function($post) {
  // Add an nonce field so we can check for it later when validating
  wp_nonce_field( 'main_product_link_bars_custom_box', 'main_product_link_bars_custom_box_nonce' );

  $amatheme_options = get_option( 'uat_options_product' );

  $top_link_bar_toggle_1 = get_post_meta( $post->ID, '_top_link_bar_toggle_1', true );
  $top_link_bar_toggle_2 = get_post_meta( $post->ID, '_top_link_bar_toggle_2', true );
  $link_bar_title_1 = get_post_meta( $post->ID, '_link_bar_title_1', true );
  $link_bar_title_2 = get_post_meta( $post->ID, '_link_bar_title_2', true );

  if ($top_link_bar_toggle_1==''):
    $top_link_bar_toggle_1=on;
  endif;

  if ($top_link_bar_toggle_2==''):
    $top_link_bar_toggle_2=on;
  endif;
?>

  <p class="admin-tips"><?php admin_tips('top_link_bar_toggle_1'); ?></p>

  <input type="hidden" id="top_link_bar_toggle_1" class="toggle-field" name="top_link_bar_toggle_1" value="<?php echo $top_link_bar_toggle_1; ?>" />
    
  <img class="toggle-check <?php echo $top_link_bar_toggle_1; ?>" src="<?php echo get_template_directory_uri(); ?>/uat-dashboard/uat-options/img/active<?php echo $top_link_bar_toggle_1; ?>.png" alt="" /><label>Turn On/Off Top Affiliate Link Bar</label>
  <br />
  <br />
    <div class="amatheme-metabox">
      <label>Top Affiliate Link Bar Text</label>
      <input class="full-width_input" type="text" name="link_bar_title_1" value="<?php echo esc_attr($link_bar_title_1); ?>" />
    </div>
  <br />
  <br />

  <p class="admin-tips"><?php admin_tips('top_link_bar_toggle_2'); ?></p>

  <input type="hidden" id="top_link_bar_toggle_2" class="toggle-field" name="top_link_bar_toggle_2" value="<?php echo $top_link_bar_toggle_2; ?>" />
    
  <img class="toggle-check <?php echo $top_link_bar_toggle_2; ?>" src="<?php echo get_template_directory_uri(); ?>/uat-dashboard/uat-options/img/active<?php echo $top_link_bar_toggle_2; ?>.png" alt="" /><label>Turn On/Off Bottom Affiliate Link Bar</label>
  <br />
  <br />
  <div class="amatheme-metabox">
    <label>Bottom Affiliate Link Bar Text</label>
    <input class="full-width_input" type="text" name="link_bar_title_2" value="<?php echo esc_attr($link_bar_title_2); ?>" />
  </div>
  <br />

  <?php
}


// save custom product specs fields meta data
function uat_affiliate_link_bars_save_data($post_id) {
 
  /*
  * We need to verify this came from the our screen and with proper authorization,
  * because save_post can be triggered at other times.
  */

  // Check if our nonce is set.
  if ( ! isset( $_POST['main_product_link_bars_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['main_product_link_bars_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'main_product_link_bars_custom_box' ) )
    return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;

  // Check the user's permissions.
  if ( 'main_product' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  $old_top_link_bar_toggle_1 = get_post_meta( $post->ID, '_top_link_bar_toggle_1', true );
  $old_top_link_bar_toggle_2 = get_post_meta( $post->ID, '_top_link_bar_toggle_2', true );
  $old_link_bar_title_1 = get_post_meta( $post->ID, '_link_bar_title_1', true );
  $old_link_bar_title_2 = get_post_meta( $post->ID, '_link_bar_title_2', true );

  $user_top_link_bar_toggle_1 = sanitize_text_field( $_POST['top_link_bar_toggle_1'] );
  $user_top_link_bar_toggle_2 = sanitize_text_field( $_POST['top_link_bar_toggle_2'] );
  $user_link_bar_title_1 = sanitize_text_field( $_POST['link_bar_title_1'] );
  $user_link_bar_title_2 = sanitize_text_field( $_POST['link_bar_title_2'] );

  update_post_meta( $post_id, '_top_link_bar_toggle_1', $user_top_link_bar_toggle_1, $old_top_link_bar_toggle_1 );
  update_post_meta( $post_id, '_top_link_bar_toggle_2', $user_top_link_bar_toggle_2, $old_top_link_bar_toggle_2 );
  update_post_meta( $post_id, '_link_bar_title_1', $user_link_bar_title_1, $old_link_bar_title_1 );
  update_post_meta( $post_id, '_link_bar_title_2', $user_link_bar_title_2, $old_link_bar_title_2 );
}
add_action( 'save_post', 'uat_affiliate_link_bars_save_data' );


// custom product specs fields
function uat_main_product_specs_function($post) {
 
  // Add an nonce field so we can check for it later when validating
  wp_nonce_field( 'main_product_inner_custom_box', 'main_product_inner_custom_box_nonce' );

  // get our custom specs values from the post meta field
  $current_specs = unserialize(get_post_meta( $post->ID, '_uat_ama_specs', true ));

  //echo '$current_specs: <pre>'; print_r( $current_specs ); echo '</pre>';

  if (is_array($current_specs)) {

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

  if(is_array($current_specs) && !empty($current_specs)):
    foreach ($current_specs as $field => $spec_meta_key) {
      $spec_value =  stripslashes($spec_meta_key['spec_value']);
    }
  endif;

  // get our custom specs fields from the products options page
  $temp_specs = get_option( 'uat_options_product' );
  $_temp_specs = $temp_specs['uat_main_product_custom_specs'];
  //print_r( $temp_specs['uat_main_product_custom_specs']);

  if(!is_array($_temp_specs)) {
    $custom_options = unserialize($_temp_specs);
  } else {
    $custom_options = $_temp_specs;
  }


  $_groupings = $custom_options;
  $groupings = array();

  if (is_array($_groupings)) {
    foreach ($_groupings as $field => $group) {
      for ($i=0; $i<count($group); $i++) {
        $groupings[$i][$field] = $group[$i];
      }
    }
  }

  echo '<div>';

  if ( is_plugin_active( 'easyazon/easyazon.php' ) ) {
    echo '<p>If you are using the Easy Azon WordPress Plugin along with this theme, you must create your product affiliate link in the editor above and insert the shortcode there, then copy and paste the shortcode into the "Product Affiliate Link" field below. Only the plain text link created by Easy Azon will work here. The advanced links are for in your content editors only.</p><p><strong>NOTE*</strong>If using the EasyAzon shortcode, do not click upload. Simply paste your shortcode in the field and it will get uploaded upon saving your review.</p>';
  } 

  echo '<table>';

  foreach ($groupings as $field => $grouping) {

    if($grouping['uat_ama_spec_toggle'] == 'off'):
      $hide_show = ' inactive-spec';
    else: 
      $hide_show = '';
    endif;

    echo '<tr class="row'.$hide_show.'">';
    $spec_value = '';

    foreach ($grouping as $value_name => $value){

      if($value_name == 'uat_ama_spec_meta_key'):
        echo '<td class="meta_key_holder">';
        echo '<input type="hidden" name="uat_ama_specs[spec_meta_key][]" value="'.$value.'">';
        echo '</td>';
        if(is_array($current_specs) && !empty($current_specs)):
          foreach ($current_specs as $field => $spec_meta_key) {
            //echo $field.' => '.$spec_meta_key['spec_meta_key'].'<br />';
            if($spec_meta_key['spec_meta_key'] == $grouping['uat_ama_spec_meta_key']){
              $spec_value =  $spec_meta_key['spec_value'];
            }
          }
        endif;
      elseif($value_name == 'uat_ama_spec_name'):
        echo '<th class="spec-name">'.$value.'</th>';
        echo '<td>';
          if($value=='Rating'):
            echo '<select name="uat_ama_specs[spec_value][]">';
            echo '<option '.selected( $spec_value, '', false).' value="">- select -</option>';
            echo '<option '.selected( $spec_value, 1, false).' value="1">1</option>';
            echo '<option '.selected( $spec_value, 1.5, false).' value="1.5">1.5</option>';
            echo '<option '.selected( $spec_value, 2, false).' value="2">2</option>';
            echo '<option '.selected( $spec_value, 2.5, false).' value="2.5">2.5</option>';
            echo '<option '.selected( $spec_value, 3, false).' value="3">3</option>';
            echo '<option '.selected( $spec_value, 3.5, false).' value="3.5">3.5</option>';
            echo '<option '.selected( $spec_value, 4, false).' value="4">4</option>';
            echo '<option '.selected( $spec_value, 4.5, false).' value="4.5">4.5</option>';
            echo '<option '.selected( $spec_value, 5, false).' value="5">5</option>';
            echo '</select>';
          else:
            echo '<input type="text" name="uat_ama_specs[spec_value][]" value="'.$spec_value.'">';
          endif;

        echo '</td>';
      endif;
    }
    echo '</tr>';
    }
  echo '</table></div>';
}

// save custom product specs fields meta data
function uat_main_product_save_data($post_id) {
 
  /*
  * We need to verify this came from the our screen and with proper authorization,
  * because save_post can be triggered at other times.
  */

  // Check if our nonce is set.
  if ( ! isset( $_POST['main_product_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['main_product_inner_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'main_product_inner_custom_box' ) )
    return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;

  // Check the user's permissions.
  if ( 'main_product' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }
 
  /* OK, its safe for us to save the data now. */
  // store old custom spec values if they exist in array
  $old_user_specs_serialized =  get_post_meta( $post_id, '_uat_ama_specs', true );

  $_groupings = $_POST['uat_ama_specs'];

  $groupings = array();

  if (is_array($_groupings)) {
    foreach ($_groupings as $field => $group) {
      for ($i=0; $i<count($group); $i++) {

        $escaped_value = $group[$i];

        // we only need to encode the spec values, not the meta keys
        if($field!='spec_meta_key'):
          $groupings[$i][$field] = base64_encode($escaped_value);
        else:
          $groupings[$i][$field] = $escaped_value;
        endif;

      }
    }
  }

  $user_specs_serialized = serialize($groupings);
  update_post_meta( $post_id, '_uat_ama_specs', $user_specs_serialized, $old_user_specs_serialized );

}
add_action( 'save_post', 'uat_main_product_save_data' );


function uat_main_product_image_function($post) { 

  //retrieve the metadata values if they exist
  $main_product_img = get_post_meta( $post->ID, '_main_product_img', true );
  $get_image_toggle = get_post_meta( $post->ID, '_prod_img_toggle', true );

  $image= esc_attr($main_product_img);

  if($image==''):
    $image_url_string = get_site_url().'/wp-content/themes/comprarmicafetera/img/no-product-image.jpg';
  else:
    $size = 'product-medium';
    $image_src=wp_get_attachment_image_src( $image, $size );
    $image_url_string = $image_src[0];
  endif;

  if ( $image_url_string == '/wp-content/themes/comprarmicafetera/img/no-product-image.jpg') {$hideshow='style="display: none"';} else {$hideshow='style="display: inline-block"';}

  ?>

  <p class="admin-tip"><?php _e('Tamaño recomendado: 700x100px', 'amatheme-options' ); ?></p>
  <br />
  <?php

  $easyazon_check = 'hidden';

  if ( is_plugin_active( 'easyazon/easyazon.php' ) ) {
    echo '<p>To add your main product image using the easyAzon Image shortcode, first add the shortcode for the image you would like to use in the editor above, then copy and paste the shortcode into this box instead of uploading an image. Make sure to use the largest image size available when creating the shortcode with EasyAzon.</p>';
    $easyazon_check = 'text';
  }

  ?>

  <!-- change type back to text to see img path -->
  <?php /* CUSTOM */
    wp_enqueue_script('jquery');
    wp_enqueue_media();
    /* END CUSTOM */
  ?>
  <input type="<?php echo $easyazon_check; ?>" id="main_product_img" name="main_product_img" value="<?php echo esc_attr($main_product_img); ?>" />
  <input id="upload_main_prod_image" type="button" class="button" value="<?php _e( 'Cargar imagen', 'amatheme' ); ?>" />

  <!-- ENABLED <input id="delete_main_product_image" name="delete_main_product_image" type="submit" class="button" <?php echo $hideshow; ?> value="<?php _e( 'Eliminar imagen', 'amatheme' ); ?>" /> END ENABLED-->

  <div id="upload_mainproduct_preview">
    <?php /* CUSTOM */
      if($main_product_img != '') echo '<br><img src="' . esc_attr($image_src[0]) . '" width="250">';
      else echo '<br><img src="/wp-content/themes/comprarmicafetera/img/no-product-image.jpg" width="250">';
      /* END CUSTOM */
    ?>

  </div>

  <script type="text/javascript">
  jQuery(document).ready(function($){
    $('#upload_main_prod_image').click(function(e) {
      e.preventDefault();
      var image = wp.media({ 
        title: 'Cargar imagen',
        multiple: false
      }).open()
      .on('select', function(e){
        var uploaded_image = image.state().get('selection').first();
        var image_id = uploaded_image.toJSON().id;
        var image_url = uploaded_image.toJSON().url;
        $('#main_product_img').val(image_id);
        $('#upload_mainproduct_preview').html('<br/><img src="' + image_url + '" width="250">');
      });
    });
  });
  </script>
  <?php /* END CUSTOM */ ?>
<?php
}


// save custom product specs fields meta data
function uat_main_product_save_image($post_id) {
  // Check if our nonce is set.
  if ( ! isset( $_POST['main_product_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['main_product_inner_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'main_product_inner_custom_box' ) )
    return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;

  // Check the user's permissions.
  if ( 'main_product' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // If old entries exist, retrieve them
  $old_image = get_post_meta( $post_id, '_main_product_img', true );
 
  // Sanitize user input.
  $image = sanitize_text_field( $_POST['main_product_img'] );


  if (0 === strpos($image, '[easyazon_image')) :
    $image_url = stripslashes(htmlspecialchars_decode($image));

    $count = preg_match('/src=(["\'])(.*?)\1/', $image_url, $match);

    if ($count === FALSE) { $image = $old_image; echo '<br /><br /><br />old image: '.$image;}
    else {
      $image = add_media_from_url($match[2], $post_id);
    }

  endif;

  // Update the meta field in the database.
  update_post_meta( $post_id, '_main_product_img', $image, $old_image );

  $user_image_toggle =  $_POST['prod_img_toggle'];
  $old_image_toggle =  get_post_meta( $post_id, '_prod_img_toggle', true );


  if( isset( $_POST[ 'prod_img_toggle' ] ) ) {
    update_post_meta( $post_id, '_prod_img_toggle',$user_image_toggle, $old_image_toggle );
  }
}
add_action( 'save_post', 'uat_main_product_save_image' );
