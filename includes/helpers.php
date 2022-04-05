<?php

function cmc_replace_year($text){
	return str_replace('%anio%', date('Y'), $text);
}
add_filter('the_title', 'cmc_replace_year', 999);
add_filter('the_content', 'cmc_replace_year', 999);
add_filter('wpseo_title', 'cmc_replace_year', 999);
add_filter('wpseo_metadesc', 'cmc_replace_year', 999);


function disable_all_feeds(){
	wp_die(__('Lo siento, nuestro contenido no está disponible mediante RSS. Por favor, visita <a href="' . get_bloginfo('url') . '">la web</a> para leerla'));
}
add_action('do_feed', 'wpb_disable_feed', 1);
add_action('do_feed_rdf', 'wpb_disable_feed', 1);
add_action('do_feed_rss', 'wpb_disable_feed', 1);
add_action('do_feed_rss2', 'wpb_disable_feed', 1);
add_action('do_feed_atom', 'wpb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);


function admin_tips($admin_tip_location) {
	return 0;
	switch ($admin_tip_location) {
		case "home_page_title":
		_e('Add your search engine optimized h1 tag for the home page here. This heading is displayed on your homepage. A great place to use one of your main key phrases. Try using it within a longer phrase that reads naturally and catches your visitor\'s attention.','ultimateazon');
		break;

		case "home_page_intro":
		_e('This is your first block of text on your homepage. It will show above the fold and is a great place to let your visitor know how you are going to help them solve a problem, alleviate a stress, make an informed buying decision, etc... Make sure to include your main key phrase somewhere in this area.','ultimateazon');
		break;

		case "top_selling_products":
		_e('Add products to the homepage "Top Products" slider or sortable table. The statistics you checked above will be automatically populated on the front end.','ultimateazon');
		break;

		case "top_selling_products_toggle":
		_e('Choose wether you want to display a top products slider, sortable table, or nothing on the homepage right under the site intro.','ultimateazon');
		break;

		case "home_page_main_content":
		_e('This is your main content editor for the homepage. Put the bulk of your homepage content here. It\'s recommended to have over 1000 words here and is the perfect place for a buying guide or any other content related to your general topic.','ultimateazon');
		break;

		case "prod_img_toggle":
		_e('Choose wether you want the main product image to be zoomable, link to the product affiliate link, or do nothing.','ultimateazon');
		break;

		default:
		_e('No tips for this field.','ultimateazon');
	}
}


/*
|--------------------------------------------------------------------------
| Facebook Script
|--------------------------------------------------------------------------
*/
function get_facebook_script(){
	return '<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.10&appId=648600791910489";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, "script", "facebook-jssdk"));</script>';
}


/*
|--------------------------------------------------------------------------
| FUNCTION THAT ADDS SOCIAL ICONS TO MENU
|--------------------------------------------------------------------------
*/
function register_social_links($items, $args){
  if ($args->theme_location == 'header_menu') {
    $options = get_option('cmc_options');
    if (!empty($options['theme_social_network_facebook']['value'])) {
      $items .= '<li class="nav-social-menu ml-md"><a href="' . $options['theme_social_network_facebook']['value'] . '" target="_blank" title=""><i class="fab fa-facebook-f"></i></a></li>';
    }
    if (!empty($options['theme_social_network_twitter']['value'])) {
      $items .= '<li class="nav-social-menu"><a href="' . $options['theme_social_network_twitter']['value'] . '" target="_blank" title=""><i class="fab fa-twitter"></i></a></li>';
    }
    if (!empty($options['theme_social_network_instagram']['value'])) {
      $items .= '<li class="nav-social-menu"><a href="' . $options['theme_social_network_instagram']['value'] . '" target="_blank" title=""><i class="fab fa-instagram"></i></a></li>';
    }
  }
  return $items;
}
add_filter('wp_nav_menu_items', 'register_social_links', 10, 2);


/*
|--------------------------------------------------------------------------
| FUNCTION THAT ADDS CHEVRON AFTER MENU ITEM IF IT HAS CHILDREN
|--------------------------------------------------------------------------
*/
function add_extra_menu_style($item_output, $item, $depth, $args){
  if ('header_menu' == $args->theme_location && $depth === 0) {
    if (in_array("menu-item-has-children", $item->classes) || in_array('page_item_has_children', $item->classes)) {
      $item_output = str_replace($args->link_after . '</a>', $args->link_after . ' <i class="fas fa-chevron-down menu-chevron-icon" data-toggle="menu"></i></a>', $item_output);
      $item_output .= '<span class="menu-triangle"></span>';
    }
  }
  return $item_output;
}
add_filter('walker_nav_menu_start_el', 'add_extra_menu_style', 10, 4);


/*
|--------------------------------------------------------------------------
| Filters
|--------------------------------------------------------------------------
*/
add_filter('xmlrpc_methods', function ($methods) {
  unset($methods['pingback.ping']);
  return $methods;
});

add_filter('nav_menu_link_attributes', function ($atts, $item, $args, $depth) {
  if ($args->theme_location === 'header_menu' && $depth === 0) {
    if (in_array("menu-item-has-children", $item->classes) || in_array('page_item_has_children', $item->classes)) {
      $atts['data-toggle'] = "sub-menu";
    }
  }
  return $atts;
}, 100, 4);


/*
|--------------------------------------------------------------------------
| Request products from API
|--------------------------------------------------------------------------
*/
function aws_signed_url($params) {

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


function get_amazon_lowest_price_product($kw){

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
  $title = (string)$item[0]->ItemAttributes->Title;
  $url = (string)$item[0]->DetailPageURL;
  $image = (string)$item[0]->LargeImage->URL;
  $list_price = (string)$item[0]->ItemAttributes->ListPrice->Amount / 100;
  $price = (string)$item[0]->Offers->Offer->OfferListing->Price->Amount / 100;
  $you_save = (string)$item[0]->Offers->Offer->OfferListing->AmountSaved->Amount / 100;
  $price_mp = (string)$item[0]->Offers->Offer->OfferListing->SalePrice->Amount / 100;
  $valid = (string)$xml->Items->Request->IsValid;
  $available = (string)$item[0]->Offers->TotalOffers;
  $error = (string)$xml->Items->Request->Errors->Error[0]->Message;
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

/*
|--------------------------------------------------------------------------
| Filter input
|--------------------------------------------------------------------------
*/
function wp_filter_input(string $filter_type, string $filter_value){

  $filter_type === 'cookie' ? $filter_type = INPUT_COOKIE : $output = null;
  $filter_type === 'server' ? $filter_type = INPUT_SERVER : $output = null;
  $filter_type === 'post' ? $filter_type = INPUT_POST : $output = null;
  $filter_type === 'get' ? $filter_type = INPUT_GET : $output = null;
  $filter_type === 'env' ? $filter_type = INPUT_ENV : $output = null;

  $output = filter_input($filter_type, $filter_value, FILTER_SANITIZE_STRING);

  return $output ?? 'filter value not found';
}