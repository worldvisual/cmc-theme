<?php

function cmc_product($attrs){

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
    if ($product_info['available'] == 1) {

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

      // new design

      $HTML = '<div class="show-product product">';
      $HTML .= '<div class="show-product-content">
				<a rel="nofollow" href="' . $product_info['url'] . '"><img src="' . $product_info['image'] . '"></a>
				<h2><a rel="nofollow" href="' . $product_info['url'] . '">' . $product_info['title'] . '</a></h2>
				<a rel="nofollow" href="' . $product_info['url'] . '" class="button">' . $button_text . '</a>
				</div>';
      $HTML .= '</div><div class="clear"></div>';

    }
  } else {

    // Replicate request if limit reached

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

        // new design

        $HTML = '<div class="show-product product">';
        $HTML .= '<div class="show-product-content">
					<a rel="nofollow" href="' . $product_info['url'] . '"><img src="' . $product_info['image'] . '"></a>
					<h2><a rel="nofollow" href="' . $product_info['url'] . '">' . $product_info['title'] . '</a></h2>
					<a rel="nofollow" href="' . $product_info['url'] . '" class="button">' . $button_text . '</a>
					</div>';
        $HTML .= '</div><div class="clear"></div>';
      }
    }
  }

  if (!is_null($content)) {  }

  // Return HTML code
  return $HTML;
}
add_shortcode('amazon', 'cmc_product');


function cmc_category($atts, $content = ''){

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

  while ($query->have_posts()) : $query->the_post();

    $data = cmc_get_prodcut_data(get_the_ID(), get_post_type());
    $result .= '<div class="product">
      <a target="_blank" href="' . get_the_permalink() . '"><img src="' . $data['image-medium'] . '"></a>
      <h2><a target="_blank" href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
      <div class="price">' . (!empty($data['price']) ? $data['price'] . '€' : '') . '</div>
      </div>';

  endwhile;
  wp_reset_postdata();

  $result .= '</div><div class="clear"></div>';

  return $result;
}
add_shortcode('cmc-category', 'cmc_category');


function cmc_list_products_box($atts, $content = ''){

  if (!empty($atts['asin'])) {
    $query = cmc_get_products_by_asin(explode(',', $atts['asin']), 'main_product');
  } else {
    $query = cmc_get_products_by_id(explode(',', $atts['id']), 'main_product');
  }

  $result = '<div class="list-products-box">';

  while ($query->have_posts()) : $query->the_post();

    $data = cmc_get_prodcut_data(get_the_ID(), get_post_type());
    $result .= '<div class="list-product-box">
      <div class="list-products-box-image"><img class="comparative-box-img" src="' . $data['image-small'] . '"></div>
      <div class="list-products-box-data">
      <span>' . get_the_title() . '</span>
      <span>' . __('Desde') . ' ' . $data['price'] . '€</span>
      <i class="icon-amazon"></i>
      </div>
      <div class="list-products-box-price">';

    if (!empty($data['discount']) && $data['discount'] != 0) {

      $result .= '<span class="price-old">' . $data['price'] . '</span>';
      $result .= '<span class="price">' . ($data['price'] - $data['discount']) . '€</span>';
    } else {

      $result .= '<span class="price">' . $data['price'] . '€</span>';
    }

    $result .= '<a rel="nofollow" href="' . $data['affiliate-link'] . '" class="button">' . __('Comprar AHORA') . '</a>
      </div>
      </div>';

  endwhile;
  wp_reset_postdata();

  $result .= '</div><div class="clear"></div>';

  return $result;
}
add_shortcode('cmc-list-products-box', 'cmc_list_products_box');


function cmc_comparative_box($atts, $content = ''){

  if (!empty($atts['asin'])) {

    $query = cmc_get_products_by_asin(explode(',', $atts['asin']), 'main_product');
  } else {

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

  while ($query->have_posts()) : $query->the_post();

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

  endwhile;
  wp_reset_postdata();

  $result .= '</table></div>';

  return $result;
}
add_shortcode('cmc-comparative-box', 'cmc_comparative_box');


function cmc_carousel($atts, $content = ''){

  if (!empty($atts['asin'])) {
    $query = cmc_get_products_by_asin(explode(',', $atts['asin']), 'main_product');
  } else {
    $query = cmc_get_products_by_id(explode(',', $atts['id']), 'main_product');
  }

  $result = '<div class="carousel">
    <h2 class="table-title">' . $atts['title'] . ' <span class="carousel-next">&#62;</span><span class="carousel-prev">&#60;</span><div class="clear"></div></h2>
    <div class="carousel-data">';
  while ($query->have_posts()) : $query->the_post();

    $data = cmc_get_prodcut_data(get_the_ID(), get_post_type());
    $result .= '<div class="carousel-product">
      <span class="carousel-name">' . get_the_title() . '</span>
      <div class="carousel-img"><img src="' . $data['image-small'] . '"></div>
      <a rel="nofollow" href="' . $data['affiliate-link'] . '" class="button">' . __('Comprar por') . ' ' . $data['price'] . '€</a>
      </div>';

  endwhile;
  wp_reset_postdata();

  $result .= '</div>
    </div><div class="clear"></div>';

  return $result;
}
add_shortcode('cmc-carousel', 'cmc_carousel');


function cmc_gallery($atts, $content = ''){

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
  while ($query->have_posts()) : $query->the_post();
    $result .= '<div class="product-gallery">
      <div class="gallery-img"><a target="_blank" href="' . esc_url(get_post_meta(get_the_ID(), 'cmc-gallery-url', true)) . '">' . get_the_post_thumbnail(get_the_ID(), 'gallery-thumbnail') . '</a></div>
      <span class="gallery-name"><a target="_blank" href="' .  esc_url(get_post_meta(get_the_ID(), 'cmc-gallery-url', true)) . '">' . get_the_title() . ' - ' . get_post_meta(get_the_ID(), 'cmc-gallery-price', true) . '€</a></span>
      <div class="gallery-excerpt">' . get_the_excerpt() . '</div>
      </div>';

  endwhile;
  wp_reset_postdata();

  $result .= '</div><div class="clear"></div>';

  return $result;
}
add_shortcode('cmc-gallery', 'cmc_gallery');


function cmc_latest_posts($atts, $content = ''){
  $args = array(
    'numberposts' => 9,
    'offset' => 0,
    'category' => 0,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'include' => '',
    'exclude' => '',
    'meta_key' => '',
    'meta_value' => '',
    'post_type' => 'post',
    'post_status' => 'publish',
    'suppress_filters' => true
  );
  $latest_posts = wp_get_recent_posts($args);
  $latest_posts_html = '';
  foreach ($latest_posts as $current) {
    $current_post_thumbnail = get_the_post_thumbnail($current['ID'], 'post-thumbnail');
    $titleSize = strlen($current['post_title']);
    if ($titleSize >= 32 &&  $titleSize < 55) {
      $psize = 90;
    } else if ($titleSize >= 55) {
      $psize = 40;
    } else {
      $psize = 120;
    }
    $latest_posts_html .= '<div class="article-2">
      <header class="entry-header-2">
      <a class="post-thumbnail-2" href="' . get_permalink($current['ID']) . '">' . $current_post_thumbnail . '</a>
      <a class="post-title-2" href="' . get_permalink($current['ID']) . '"><h2>' . $current['post_title'] . '</h2></a>
      </header>
      <div class="entry-content-2">' . mb_substr(wp_strip_all_tags($current['post_content']), 0, $psize) . '...</div>
      <div class="read-more"><a href="' . get_permalink($current['ID']) . '">Leer más</a></div>
      </div>';
  }
  wp_reset_query();

  $latest_posts_html = $latest_posts_html . '<div class="clear"></div>';
  return $latest_posts_html;
}
add_shortcode('cmc-latest-posts', 'cmc_latest_posts');
