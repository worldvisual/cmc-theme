<?php

function cmc_get_next_products(){

  if (!empty($_POST['taxonomy']) && !empty($_POST['term'])) {
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
  } else {
    $args = array(
      'posts_per_page' => 12,
      'offset' => $_POST['offset'],
      'post_type' => $_POST['postType'],
      'orderby' => 'date'
    );
  }

  $query = new WP_Query($args);

  if (!$query->have_posts()) {
    echo 2;
    die;
  } else {
    $result = '';

    while ($query->have_posts()) : $query->the_post();

      $data = cmc_get_prodcut_data(get_the_ID(), get_post_type());
      $titleSize = strlen(get_the_title());
      if ($titleSize >= 32 &&  $titleSize < 55) {
        $psize = 90;
      } else if ($titleSize >= 55) {
        $psize = 40;
      } else {
        $psize = 120;
      }

      if ($data['price'] != '') {
        $price = '<div class="read-more price"><span>' . $data['price'] . ' €</span></div>';
      } else {
        $price = '<div class="read-more"><a href="' . get_the_permalink() . '">' . __('Acceder') . '</a></div>';
      }
      $result .= '<div class="article-2">
			<div class="entry-header-2">
			<a class="post-thumbnail-2" href="' . get_the_permalink() . '"><img src="' . $data['image-medium'] . '"></a>
			<a class="post-title-2" href="' . get_the_permalink() . '"><h2>' . get_the_title() . '</h2></a>
			</div>
			<div class="entry-content-2">' . mb_substr(wp_strip_all_tags(get_the_content()), 0, $psize) . '...</div>
			' . $price . '
			</div>';

    endwhile;
    wp_reset_postdata();

    echo $result;
    die;
  }
}
add_action('wp_ajax_cmc_get_next_products', 'cmc_get_next_products');
add_action('wp_ajax_nopriv_cmc_get_next_products', 'cmc_get_next_products');
