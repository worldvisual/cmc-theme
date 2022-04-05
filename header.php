<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php $options = get_option('cmc_options'); ?>
	<title><?php wp_title(''); ?></title>
	<link rel="shortcut icon" href="<?php echo $options['theme_favicon']['value']; ?>">
	<?php if(is_search()): ?><meta name="robots" content="noindex"><?php endif; ?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TK5RDBV');</script>
	<!-- End Google Tag Manager -->
	<!-- CrazyEgg Settings -->
	<script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0034/9897.js" async="async"></script>
	<!-- CrazyEgg Settings -->
	<!-- Soporte para móviles -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?>">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.jpg">
	<meta name="theme-color" content="#000033">
	<meta name="google-site-verification" content="S0HYGuIEvoYNVTHi5YdbSZKFcN8vxwOeonOlRahmaKo" />
	<meta name="application-name" content="<?php bloginfo('name'); ?>">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.jpg" sizes="192x192">
	<!-- End -->
		<!--- Atomik Lib settings --->
	<link rel="preconnect" href="https://partners.mcontigo.com">
	<script type="text/javascript">
		window.atomikLib = window.atomikLib || { cmd: [] };
		window.atomikLib.localConfig = {
			defaultUnit: "/7120678/mcontigo/comprarmicafetera.com",
			sticky: {
				enabled: true,
				trigger: "ready"
			},
			cmp: {
				enabled: true,
				internal: true,
				timeout: 8000,
				didomiConfig: {
					app: {
						apiKey: "6049ab13-a5f3-4c15-b66b-edae53142afc",
						name: "Comprar mi Cafetera",
						logoUrl: "https://www.comprarmicafetera.com/wp-content/uploads/2020/12/Logo-CMC-580-Def-3.png"
					},
					theme: {
						color: "#1f1f1f",
						linkColor: "#1f1f1f",
					},
					languages: {
						enabled: ["es"],
						default: "es",
					},
				},
			},

		};
	</script>
	<script type="text/javascript" src="https://partners.mcontigo.com/loader.js?d=comprarmicafetera.com" async id="loader"></script>
	<!--- End Atomik Lib settings --->	
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3666319173489616"
     crossorigin="anonymous"></script>
	<?php echo get_facebook_script(); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TK5RDBV"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

		<header id="top-fixed-menu">  
			<div class="header-top-wrapper">
				<div class="container">
					<div class="header-top-inner">
					
					<!-- header top bar -->
					<div class="header-top">
						<div class="logo-nav-menu">
							<div class="open-nav-menu">
								<span></span>
							</div>
							<div class="brand-logo-thumbnail">
								<a href="<?php echo esc_url(home_url('/')); ?>">
									<img alt="<?php _e('Logo de '); bloginfo('name'); ?>" src="<?php echo $options['theme_logo']['value']; ?>">
								</a>
							</div>
						</div>
						<div class="header-top-search-box">
							<div class="search-box-group">
								<form id="searchform" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
									<input type="search" id="s" name="s" class="search-box" placeholder="<?php _e('Busca aquí...'); ?>">
									<button class="search-btn"><i class="fa fa-search"></i></button>
								</form>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
				<!-- header nav menu -->
			<div class="header">
				<div class="header-main">
					<div class="menu-overlay">
					</div>
					<!-- navigation menu start -->
					<nav class="nav-menu">
						<div class="close-nav-menu">
							<i class="fas fa-times"></i>
						</div>
						<?php
						$defaults = array(
							'theme_location'  => 'header_menu',
							'menu'            => '',
							'container'       => 'ul',
							'container_class' => '',
							'container_id'    => '',
							'menu_class'      => 'menu',
							'menu_id'         => '',
							'echo'            => true,
							'fallback_cb'     => 'wp_page_menu',
							'before'          => '',
							'after'           => '',
							'link_before'     => '',
							'link_after'      => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth'           => 2,
							'walker'          => ''
						);
						   
						wp_nav_menu( $defaults );
						?>
					</nav>
					<!-- navigation menu end -->
				</div>
			</div>
		</header>