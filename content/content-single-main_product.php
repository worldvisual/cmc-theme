<?php $options = get_option('cmc_options'); ?>
<?php $data = cmc_get_prodcut_data(get_the_ID(), get_post_type()); ?>
<div class="group-product-grid">
  <div class="product-grid-1">
    <div class="product-menu">
      <img class="product-menu-img" src="<?php _e(esc_url($data['image-small'])); ?>">
      <div class="product-menu-data">
        <h2><?php the_title(); ?></h2>
        <span class="product-stars"><?php _e($data['score-stars-small']); ?></span>
        <div class="product-menu-features">
          <?php if (get_post_type() == 'main_product') : ?>
            <span>
              <?php esc_html_e($data['type']); ?>
            </span>
          <?php endif; ?>
          <span>
            <?php esc_html_e($data['transaction']); ?>

          </span>
          <span>
            <?php esc_html_e($data['capacitance']); ?>
          </span>
        </div>
      </div>
      <div class="clear"></div>

      <div class="product-menu-menu">
        <div><span class="number">1</span> <button class="btGoToContent" onclick="goToContent('Características')">Características</button></div>
        <div><span class="number">2</span> <button class="btGoToContent" onclick="goToContent('Ventajas')">Ventajas</button></div>
        <div><span class="number">3</span> <button class="btGoToContent" onclick="goToContent('Desventajas')">Desventajas</button></div>
        <div><span class="number">4</span> <button class="btGoToContent" onclick="goToContent('Conclusiones')">Conclusiones</button></div>
      </div>

      <a rel="nofollow" class="aawp-button aawp-button--buy aawp-button aawp-button--amazon aawp-button--icon aawp-button--icon-amazon-black" href="<?php _e(esc_url($data['affiliate-link'])); ?>">
        <?php _e($data['button-text']); ?>
      </a>

    </div>
  </div>

  <div class="product-grid-2">
    <div class="product-header">
      <div class="product-header_content">
        <h1><?php the_title(); ?></h1>
        <span class="product-stars"><?php _e($data['score-stars']); ?></span>
        <div class="product-facebook fb-share-button" data-href="<?php esc_html_e(get_the_permalink()); ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php esc_html_e(get_the_permalink()); ?>&src=sdkpreparse"><?php esc_html_e('Compartir'); ?></a></div>
        <div class="product-data">
          <div><label><?php esc_html_e('Nombre:'); ?></label><span><?php  _e($data['product-name']); ?></span></div>
          <div><label><?php esc_html_e('Marca:'); ?></label><span><?php _e($data['brand']); ?></span></div>
          <?php if (get_post_type() == 'main_product') : ?><div><label><?php esc_html_e('Tipo:'); ?></label><span><?php  _e($data['type']); ?></span></div><?php endif; ?>
          <div><label><?php esc_html_e('Operación:'); ?></label><span><?php _e($data['transaction']); ?></span></div>
          <div><label><?php esc_html_e('Capacidad:'); ?></label><span><?php _e($data['capacitance']); ?></span></div>
        </div>
        <a rel="nofollow" class="aawp-button aawp-button--buy aawp-button aawp-button--amazon aawp-button--icon aawp-button--icon-amazon-black product-button-2" href="<?php esc_html_e(esc_url($data['affiliate-link'])); ?>"><?php esc_html_e($data['button-text']); ?></a>
        <i class="icon-amazon"></i>
      </div>

      <div class="product-img mobile" data-image="<?php esc_attr_e($data['image']); ?>"></div>

    </div>

    <div class="product-content">
      <?php the_content(); ?>
    </div>

    <?php if (get_post_type() == 'main_product') : ?>
      <div class="related-products">
        <h3><?php esc_html_e('Productos Relacionados'); ?></h3>
        <?php
        cmc_related_products('main_product', 'product-category', get_the_terms(get_the_ID(), 'product-category')[0]->slug, get_the_ID());
        ?>
      </div>
    <?php endif; ?>
    <?php if (comments_open() || get_comments_number()) : comments_template();
  endif; ?>
  <?php if (comments_open() || get_comments_number()) : esc_html_e($options['theme_legal_comments']['value']);
endif; ?>
</div>

<div class="<?php if ( !wp_is_mobile() ) { esc_html_e('product-grid-3'); } ?>">
  <?php
  get_sidebar();
  ?>
</div>

</div>