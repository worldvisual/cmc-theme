<?php $options = get_option('cmc_options'); ?>
<?php $data = cmc_get_prodcut_data(get_the_ID(), get_post_type()); ?>
<div class="group-product-grid">
  <div class="product-grid-1">
    <div class="product-menu">
      <img class="product-menu-img" src="<?php echo $data['image-small']; ?>">
      <div class="product-menu-data">
        <h2><?php the_title(); ?></h2>
        <span class="product-stars"><?php echo $data['score-stars-small']; ?></span>
        <div class="product-menu-features"><?php if (get_post_type() == 'main_product') : ?><span><?php echo $data['type']; ?></span><?php endif; ?><span><?php echo $data['transaction']; ?></span><span><?php echo $data['capacitance']; ?></span></div>
      </div>
      <div class="clear"></div>

      <div class="product-menu-menu">
        <div><span class="number">1</span> <button class="btGoToContent" onclick="goToContent('Características')">Características</button></div>
        <div><span class="number">2</span> <button class="btGoToContent" onclick="goToContent('Ventajas')">Ventajas</button></div>
        <div><span class="number">3</span> <button class="btGoToContent" onclick="goToContent('Desventajas')">Desventajas</button></div>
        <div><span class="number">4</span> <button class="btGoToContent" onclick="goToContent('Conclusiones')">Conclusiones</button></div>
      </div>

      <a rel="nofollow" class="aawp-button aawp-button--buy aawp-button aawp-button--amazon aawp-button--icon aawp-button--icon-amazon-black" href="<?php echo $data['affiliate-link']; ?>"><?php echo $data['button-text']; ?></a>

      <?php /*if($data['available'] == 1) {
                            echo '<a rel="nofollow" class="aawp-button aawp-button--buy aawp-button aawp-button--amazon aawp-button--icon aawp-button--icon-amazon-black" href="' . $data['affiliate-link'] . '">' . $data['button-text'] . '</a>';
                        }
                        else {
                            echo '<span class="sold-out">' . __('Agotado') . '</span>';
                          }*/ ?>
    </div>
  </div>

  <div class="product-grid-2">
    <div class="product-header">
      <div class="product-header_content">
        <h1><?php the_title(); ?></h1>
        <span class="product-stars"><?php echo $data['score-stars']; ?></span>
        <div class="product-facebook fb-share-button" data-href="<?php echo get_the_permalink(); ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink(); ?>&src=sdkpreparse"><?php _e('Compartir'); ?></a></div>
        <div class="product-data">
          <div><label><?php _e('Nombre:'); ?></label><span><?php echo $data['product-name']; ?></span></div>
          <div><label><?php _e('Marca:'); ?></label><span><?php echo $data['brand']; ?></span></div>
          <?php if (get_post_type() == 'main_product') : ?><div><label><?php _e('Tipo:'); ?></label><span><?php echo $data['type']; ?></span></div><?php endif; ?>
          <div><label><?php _e('Operación:'); ?></label><span><?php echo $data['transaction']; ?></span></div>
          <div><label><?php _e('Capacidad:'); ?></label><span><?php echo $data['capacitance']; ?></span></div>
        </div>
        <a rel="nofollow" class="aawp-button aawp-button--buy aawp-button aawp-button--amazon aawp-button--icon aawp-button--icon-amazon-black product-button-2" href="<?php echo $data['affiliate-link']; ?>"><?php echo $data['button-text']; ?></a>
        <i class="icon-amazon"></i>
      </div>

      <div class="product-img mobile" data-image="<?php echo $data['image']; ?>"></div>

    </div>

    <div class="product-content">
      <?php the_content(); ?>
    </div>

    <?php if (get_post_type() == 'main_product') : ?>
      <div class="related-products">
        <h3><?php _e('Productos Relacionados'); ?></h3>
        <?php
          echo cmc_related_products('main_product', 'product-category', get_the_terms(get_the_ID(), 'product-category')[0]->slug, get_the_ID());
          ?>
      </div>
    <?php endif; ?>
    <?php if (comments_open() || get_comments_number()) : comments_template();
    endif; ?>
    <?php if (comments_open() || get_comments_number()) : echo $options['theme_legal_comments']['value'];
    endif; ?>
  </div>

  <div class="<?php if ( !wp_is_mobile() ) { echo 'product-grid-3'; } ?>">
    <?php
      get_sidebar();
    ?>
  </div>

</div>