			<?php $options = get_option('cmc_options'); ?>
			<div class="clear"></div>
			<!-- footer -->
			<footer id="footer">
				<div class="container">
					<div class="footer-top">
						<div class="footer-logo">
							<a href="<?php echo esc_url(home_url('/')); ?>">
								<img alt="<?php _e('Logo de '); bloginfo('name'); ?>" src="<?php echo $options['theme_logo']['value']; ?>">
							</a>
						</div>
					</div>
					<!-- horizontal line -->
					<hr>

					<div class="row mb-md">
						<div class="col-12 col-lg-3">
							<?php dynamic_sidebar('footer-widgets-1'); ?>
						</div>
						<div class="col-6 col-lg-3">
							<?php dynamic_sidebar('footer-widgets-2'); ?>
						</div>
						<div class="col-6 col-lg-3">
							<?php dynamic_sidebar('footer-widgets-3'); ?>
						</div>
						<div class="col-12 col-lg-3">
							<?php dynamic_sidebar('footer-widgets-4'); ?>
						</div>
					</div>

					<div class="text-center mt-md">
						<?php dynamic_sidebar('footer-widgets-5'); ?>
					</div>
				</div>
				<hr>
				<!-- footer copyright text -->
				<div class="footer-copy-right-text text-center">
					<p class="footer-post-text">&copy; <?php echo date('Y'); ?> Copyright ComprarMiCafetera.com. Todos los derechos reservados.</p>
				</div>
			</footer>

		<?php echo get_rich_snippets(); ?>
		<?php wp_footer(); ?>
	</body>
</html>