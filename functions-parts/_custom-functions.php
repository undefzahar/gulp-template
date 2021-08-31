<?php
function print_svg_ic($icon_id) {
  ?>
    <svg>
      <use xlink:href="<?php echo get_template_directory_uri() ?>/build/static/images/svg/symbol/sprite.svg#<?php echo $icon_id ?>"></use>
    </svg>
  <?php
}



function cut_p_tags($dirty_html) {
  $nice_html = $dirty_html;
  $nice_html = str_replace("<p>", "", $nice_html);
  $nice_html = str_replace("</p>", "", $nice_html);
  return $nice_html;
}


function print_store_card($post_id) {
  ?>
    <div class="stores-card">
        <?php $adress = get_field('adresa_tochky_prodazhu', $post_id); ?>
        
        <div class="stores-card__info">
            <span class="add-text green"><?php echo $adress['city'] ?></span>
            
            <span><?php echo $adress['address'] ?></span>
            <span class="stores-card__title"><?php echo get_the_title($post_id) ?></span>
            
              
            <?php if( have_rows('nomera_telefoniv', $post_id) ): ?>
                <div class="stores-card__numbers">
                <?php while ( have_rows('nomera_telefoniv', $post_id) ) : the_row();
                    $num = get_sub_field('telefon'); ?>
                    <a href="tel:<?php echo $num ?>"><?php echo $num ?></a>
                <?php endwhile; ?> 
                </div>
            <?php endif; ?> 
            
        </div>
        <div class="stores-card__logo">
            <?php $logo = get_field('logotyp_tochky', $post_id);
            if ($logo): ?>
                <img src="<?php echo $logo['sizes']['medium_large'] ?>" alt="">
            <?php else: ?>
                <span>logo</span>
            <?php endif; ?>
        </div>
    </div>
  <?php
}

function isMobile() {
  $detect = new Mobile_Detect;
  return $detect->isMobile(); 
}
function isTablet() {
  $detect = new Mobile_Detect;
  return $detect->isTablet(); 
}
function isDesktop() {
  return (!isTablet() && !isMobile());
}

