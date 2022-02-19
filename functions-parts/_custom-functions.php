<?php
function print_svg_ic($icon_id) {
  ?>
    <svg>
      <use xlink:href="<?php echo get_template_directory_uri() ?>/build/static/images/svg/symbol/sprite.svg#<?php echo $icon_id ?>"></use>
    </svg>
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