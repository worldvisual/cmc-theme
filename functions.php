<?php

/*
|--------------------------------------------------------------------------
| Load dependencies
|--------------------------------------------------------------------------
*/
load_dependencies("includes", [
  "helpers",
  "shortcodes",
  "post_type",
  "wp_ajax",
]);
load_dependencies("includes/cmc", [
  "cmc_load_assets",
  "cmc_options",
  "cmc_products",
  "cmc_gallery",
  "cmc_widgets",
]);
load_dependencies("includes/metabox", [
  'meta-boxes-brands',
  'meta-boxes-main_product',
]);

function load_dependencies($path, $array)
{
  foreach ($array as  $dependency) {
    require_once get_template_directory() . "/$path/$dependency.php";
  }
}

/*
|--------------------------------------------------------------------------
| Amazon - Data Account
|--------------------------------------------------------------------------
*/
$API_options = get_option('cmc_options');
$accessKeyId = $API_options['theme_api_accessKeyId']['value'];
$secretKey = $API_options['theme_api_secretKey']['value'];
$trackingId = $API_options['theme_api_trackingId']['value'];
$region = "es";
$savetext = "Comprando este producto hoy, te ahorras…";
$CTAtext = "Comprar en Amazon AHORA - ";
$pricetext = "Precio Actual:";
$searchonAmazontext = "Consulta la mejor oferta en Amazon";
$logourl = "https://images-na.ssl-images-amazon.com/assets/images/G/30/associates/mariti/banner/uk_associates_14-07-2015_amazon-logo_de-assoc_3_234x60.jpg";