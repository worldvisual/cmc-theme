<?php if ( !wp_is_mobile() ) { 
?>
<aside id="secondary" class="widget-area" role="complementary">
	<?php
		if(is_active_sidebar('sidebar-widgets')) {
			dynamic_sidebar('sidebar-widgets');
		}
	?>
</aside>
<?php
} ?>
